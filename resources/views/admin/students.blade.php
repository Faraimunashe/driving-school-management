<x-app-layout>
    <div class="pagetitle">
        <h1>Students</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Students</li>
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
                        <h5 class="card-title">Students</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Firstname</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($students as $student)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $student->fname }}</td>
                                        <td>{{ $student->lname }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$students->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
