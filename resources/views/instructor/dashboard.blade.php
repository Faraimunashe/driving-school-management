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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bookings</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student</th>
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
                                        <td>{{ $booking->student_fname.' '.$booking->lname }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>{{ $booking->start_time }}</td>
                                        <td>{{ $booking->end_time }}</td>
                                        <td>{{ $booking->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editStatus{{ $booking->id }}"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                            <!-- Edit tolfee Modal -->
                                            <div class="modal fade" id="editStatus{{ $booking->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('instructor-dashboard') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Booking Status</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="booking_id" value="{{$booking->id}}" required>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-form-label">Status:</label>
                                                                    <div class="">
                                                                        <select name="status" class="form-control" required>
                                                                            <option selected disabled>Select Status</option>
                                                                            <option value="APPROVED">APPROVED</option>
                                                                            <option value="REJECTED">REJECTED</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Change status</button>
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
</x-app-layout>
