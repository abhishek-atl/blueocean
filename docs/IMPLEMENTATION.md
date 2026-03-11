# Free Therapist Finder Function

## Overview

A comprehensive function has been implemented in the `BookingService` class to find available therapists for a given date and time. The function automatically handles:

- ✅ Therapist working schedules (from `therapist_schedule` table)
- ✅ Therapist holidays (from `therapists_holidays` table)
- ✅ Existing bookings (from `bookings` table)
- ✅ Appointment duration validation

## Implementation Details

### Main Function: `getFreeTherapistsOnDateTime()`

**Location:** `app/Services/BookingService.php`

**Signature:**
```php
public function getFreeTherapistsOnDateTime(
    $date,           // string('Y-m-d') or DateTime object
    $time,           // string('H:i', e.g., '09:00')
    $duration = 60,  // int (minutes)
    $therapistIds = null  // array of user IDs (optional)
): \Illuminate\Database\Eloquent\Collection
```

**Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$date` | string/DateTime | Yes | Date in 'Y-m-d' format or DateTime object |
| `$time` | string | Yes | Time in 'H:i' format (e.g., '09:00', '14:30') |
| `$duration` | int | No | Duration of appointment in minutes (default: 60) |
| `$therapistIds` | array | No | Filter by specific therapist IDs |

**Returns:**
- `Illuminate\Database\Eloquent\Collection` - Collection of available `User` model instances (therapists)

### Helper Function: `isTimeWithinWorkingHours()`

**Signature:**
```php
private function isTimeWithinWorkingHours(
    DateTime $startDateTime,
    DateTime $endDateTime,
    string $workingHours
): bool
```

Validates that an appointment time falls completely within the therapist's working hours for that day.

**Working Hours Format:** `"HH:MM-HH:MM"` (e.g., `"09:00-17:00"`)

## Database Structure

### therapist_schedule table
```
id              (bigint, primary key)
user_id         (int, foreign key to users)
mon             (string, format: "HH:MM-HH:MM")
tue             (string, format: "HH:MM-HH:MM")
wed             (string, format: "HH:MM-HH:MM")
thu             (string, format: "HH:MM-HH:MM")
fri             (string, format: "HH:MM-HH:MM")
sat             (string, format: "HH:MM-HH:MM" or null)
sun             (string, format: "HH:MM-HH:MM" or null)
created_at      (timestamp)
updated_at      (timestamp)
```

### therapists_holidays table
```
id              (bigint, primary key)
user_id         (int, foreign key to users)
start_date      (datetime)
end_date        (datetime)
created_at      (timestamp)
updated_at      (timestamp)
```

### bookings table
```
id                           (bigint, primary key)
user_id                      (int, therapist ID)
treatment_id                 (int)
appointment_start            (datetime) ← Used for conflict detection
appointment_finish           (datetime) ← Used for conflict detection
status                       (enum: 'new', 'cancelled', 'processing')
... other fields ...
created_at                   (timestamp)
updated_at                   (timestamp)
```

## Usage Examples

### Example 1: Basic Usage
```php
$bookingService = app(\App\Services\BookingService::class);

$availableTherapists = $bookingService->getFreeTherapistsOnDateTime('2024-03-18', '10:00');

foreach ($availableTherapists as $therapist) {
    echo $therapist->name . " - Available\n";
}
```

### Example 2: With Custom Duration
```php
// Find therapists available for 90-minute appointment
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime(
    '2024-03-18',
    '14:00',
    90  // 90 minutes
);
```

### Example 3: Using DateTime Object
```php
$date = new \DateTime('2024-03-18');
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime($date, '09:00', 60);
```

### Example 4: Filter Specific Therapists
```php
$specificIds = [1, 5, 8];
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime(
    '2024-03-18',
    '11:00',
    60,
    $specificIds
);
```

### Example 5: In a Controller
```php
namespace App\Http\Controllers;

use App\Services\BookingService;

class BookingController extends Controller
{
    public function getAvailableTherapists(BookingService $bookingService)
    {
        $date = request('date');       // e.g., '2024-03-18'
        $time = request('time');       // e.g., '10:00'
        $duration = request('duration', 60);

        $therapists = $bookingService->getFreeTherapistsOnDateTime($date, $time, $duration);

        return response()->json([
            'count' => $therapists->count(),
            'therapists' => $therapists->map(fn($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'email' => $t->email,
                'profile' => $t->therapist_profile,
            ]),
        ]);
    }
}
```

## How the Function Works

### Step 1: Validate Basic Requirements
- Filters active therapists with a working schedule
- Optionally filters by specific therapist IDs

### Step 2: Check Working Schedule
- Gets the day of week (Mon-Sun)
- Retrieves working hours from `therapist_schedule` table
- Verifies appointment time falls within working hours
- Entire appointment (start + duration) must fit within working hours

### Step 3: Check for Holidays
- Queries `therapists_holidays` table
- Excludes therapists if holiday period overlaps with appointment time
- Uses inclusive date range: `start_date <= appointment_end && end_date >= appointment_start`

### Step 4: Check for Existing Bookings
- Queries `bookings` table for user (therapist)
- Detects three types of conflicts:
  1. Existing booking starts during requested appointment
  2. Existing booking ends during requested appointment
  3. Existing booking completely contains requested appointment
- Only considers **active bookings** (status: 'new' or 'processing')
- Cancelled bookings are ignored

### Step 5: Return Results
- Returns a collection of available therapists
- Can be empty if no therapists match criteria

## Conflict Detection Logic

The function detects booking conflicts using this overlap check:

```
Appointment A conflicts with Appointment B if:
  (A.start < B.finish) AND (A.finish > B.start)
```

This covers all overlap scenarios:
- Partial overlap (any part of appointment conflicts)
- Exact overlap (same time)
- One appointment contained within another
- Edge cases (appointments touching at exact times don't conflict)

## Files Created/Modified

### Modified Files
1. **`app/Services/BookingService.php`**
   - Added `getFreeTherapistsOnDateTime()` method
   - Added `isTimeWithinWorkingHours()` helper method

### New Files Created
1. **`app/Models/Booking.php`** - Eloquent model for bookings table
2. **`USAGE_EXAMPLES.php`** - Comprehensive usage examples
3. **`tests/Feature/GetFreeTherapistsTest.php`** - Unit tests for the function
4. **`IMPLEMENTATION.md`** - This documentation file

## Testing

Run the test suite:
```bash
php artisan test tests/Feature/GetFreeTherapistsTest.php
```

Test coverage includes:
- ✅ All therapists available
- ✅ Excluding therapists on holiday
- ✅ Excluding therapists with conflicting bookings
- ✅ Allowing non-conflicting bookings
- ✅ Respecting working hours
- ✅ Filtering by specific IDs
- ✅ Different appointment durations

## Performance Considerations

### Query Optimization
- Uses eager loading with `whereHas()` for schedule relationship
- Lazy-loads holidays and bookings per therapist
- Uses database queries for existence checks to minimize data transfer

### Scalability
- For large therapist bases, consider adding treatments/postcodes filters
- Can add caching for schedule data (rarely changes)
- Consider pagination for results if > 100 therapists available

### Potential Improvements
1. **Caching:** Cache working schedules (daily)
2. **Indexes:** Add indexes on:
   - `therapists_holidays.user_id`
   - `bookings.user_id, bookings.appointment_start, appointment_finish`
3. **Batch Queries:** Use `load()` to eager load relationships
4. **Query Limit:** Add limit to prevent massive result sets

## Error Handling

The function validates:
- ✅ Date format (converts string to DateTime)
- ✅ Time format (parses H:i)
- ✅ Working hours format (validates "HH:MM-HH:MM")
- ✅ Duration (positive integer)

Returns empty collection if:
- No therapists found with schedule
- All therapists excluded due to: holidays, bookings, or hours
- Date/time is invalid

## Edge Cases Handled

1. **Same-day conflicts:** Overlapping bookings on same day
2. **Midnight-spanning appointments:** (rare, but supported)
3. **Partial-day holidays:** Holidays overlapping appointment time
4. **Closed days:** null values in schedule (interpreted as closed)
5. **Non-standard hours:** e.g., "14:00-22:00" (opens in afternoon)
6. **Weekend schedules:** Different hours or closed on weekends

## Integration Notes

- Uses Laravel's Eloquent ORM for queries
- Compatible with dependency injection (constructor or method)
- Returns native Eloquent collections (chainable)
- No external dependencies required

## Future Enhancements

To extend functionality:

```php
// Get available time slots instead of therapists
public function getAvailableTimeSlots($date, $therapistIds = null, $duration = 60)

// Get therapists by treatment specialty
public function getFreeTherapistsForTreatment($treatmentId, $date, $time, $duration)

// Bulk check multiple dates
public function getTherapistAvailability($therapistId, $startDate, $endDate)

// Cache therapist availability
public function getCachedAvailableTherapists($date, $time, $duration)
```

## License & Attribution

This implementation follows Laravel best practices and BlueOcean project conventions.
