<x-app-layout>
    <div class="pagetitle">
        <h1>Bookings</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Bookings</li>
              </ol>
          </nav>
      </div>
      <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <x-alert/>
            <div class="col-12 mb-3">
                @if (\App\Models\Recommend::where('user_id', Auth::id())->first())
                    <button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#addtolfee">
                        Make New Booking
                    </button>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List of Bookings</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $booking->fname.' '.$booking->lname }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>{{ $booking->start_time }}</td>
                                        <td>{{ $booking->end_time }}</td>
                                        <td>{{ $booking->status }}</td>

                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBooking{{ $booking->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                         <!-- Delete tolfee Modal -->
                                         <div class="modal fade" id="deleteBooking{{ $booking->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('user-bookings.destroy', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Booking</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete this booking?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <button type="submit" class="btn btn-danger">Yes Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Large Modal -->
    <div class="modal fade" id="addtolfee" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('user-bookings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Instructor:</label>
                            <div class="">
                                <select name="instructor_id" class="form-control" required>
                                    <option selected disabled>Select Instructor</option>
                                    @foreach (\App\Models\Instructor::all() as $instructor)
                                        <option value="{{$instructor->id}}">{{$instructor->fname.' '.$instructor->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Date:</label>
                            <div class="">
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Start Time:</label>
                            <div class="">
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">End Time:</label>
                            <div class="">
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Large Modal-->
</x-app-layout>
