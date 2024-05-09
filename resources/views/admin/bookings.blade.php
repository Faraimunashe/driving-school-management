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
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
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
                                        <td>{{ $booking->student_id }}</td>
                                        <td>{{ $booking->instructor_id }}</td>
                                        <td>{{ $booking->status }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>{{ $booking->start_date }}</td>
                                        <td>{{ $booking->end_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$bookings->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
