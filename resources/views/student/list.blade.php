@extends('layout.contentLayoutMaster')

@section('title', 'Student | List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Student /</span> List
    </h5>

    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student List</h5>
                </div>
                <div class="table-responsive">

                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        <div>
                            <button class="btn btn-outline-secondary">
                                <i class='bx bx-filter-alt'></i>
                            </button>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="search" class="form-control" id="search" placeholder="Search">
                            <span class="input-group-text cursor-pointer" id="search-icon">
                                <i class='bx bx-search-alt'></i>
                            </span>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Is Graduate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1010230-1</td>
                                <td>Dela Cruz, Juan Jr.</td>
                                <td>BSCrim</td>
                                <td>
                                    <span class="badge rounded-pill bg-label-success">Yes</span>
                                </td>
                                <td>
                                    <a href="/student/information" class="text-primary fs-5">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Malapsan, Tangol</td>
                                <td>BSHRTM</td>
                                <td>
                                    <span class="badge rounded-pill bg-label-danger">No</span>
                                </td>
                                <td>
                                    <a href="/student/information" class="text-primary fs-5">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>20</td>
                                <td>2030</td>
                                <td>
                                    <span class="badge rounded-pill bg-label-danger">No</span>
                                </td>
                                <td>
                                    <a href="/student/information" class="text-primary fs-5">

                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="px-3 pt-3 float-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

@endsection