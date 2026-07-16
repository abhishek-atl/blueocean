<p>New Review posted</p>
<p>First name: {{$review->first_name }}<br />
    Last name: {{$review->last_name }}<br />
    Email: {{$review->email }}<br />
    Location: {{$review->location }}<br />
    Rating: {{$review->evaluation }}<br />
    Comment: {{$review->comment }}<br />
</p>
<a href="{{ route('admin.reviews.edit', ['id' => $review->id]) }}">Go to Edit Review</a>