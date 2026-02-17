@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">New Bookings</h6>
                    <h3 class="text-bold mb-10">120</h3>
                    <p class="text-sm text-success">
                        <i class="fa-solid fa-chevron-up"></i> +2.00%
                        <span class="text-gray">(30 days)</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Income</h6>
                    <h3 class="text-bold mb-10">$74,567</h3>
                    <p class="text-sm text-success">
                        <i class="fa-solid fa-chevron-up"></i> +5.45%
                        <span class="text-gray">Increased</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Payout</h6>
                    <h3 class="text-bold mb-10">$24,567</h3>
                    <p class="text-sm text-danger">
                        <i class="fa-solid fa-chevron-down"></i> -2.00%
                        <span class="text-gray">Expense</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon orange">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">New User</h6>
                    <h3 class="text-bold mb-10">34567</h3>
                    <p class="text-sm text-danger">
                        <i class="fa-solid fa-chevron-down"></i></i> -25.00%
                        <span class="text-gray"> Earning</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-30">Recent Bookings</h6>
                    </div>
                    <div class="right">
                        <div class="select-style-1">
                            <div class="select-position select-sm">
                                <select class="light-bg">
                                    <option value="">Today</option>
                                    <option value="">Yesterday</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table top-selling-table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Therapist Name</th>
                                <th>Treatment</th>
                                <th>Status</th>
                                <th>
                                    <h6 class="text-sm text-medium text-end">
                                        Actions <i class="lni lni-arrows-vertical"></i>
                                    </h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Jenniffer</td>
                                <td>Classic Swwedish Massage</td>
                                <td><span class="status-btn success-btn">Completed</span></td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td>Jenniffer</td>
                                <td>Classic Swwedish Massage</td>
                                <td><span class="status-btn success-btn">Completed</span></td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td>Jenniffer</td>
                                <td>Classic Swwedish Massage</td>
                                <td><span class="status-btn success-btn">Completed</span></td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection