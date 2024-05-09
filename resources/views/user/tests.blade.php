<x-app-layout>
    <div class="pagetitle">
        <h1>Session Tests</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Tests</li>
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
                        <h5 class="card-title">Tests</h5>
                        <form action="{{route('tests.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="test_session_id" value="{{$ses->id}}" required>
                            <button type="submit" class="btn btn-danger">Start New Test</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Test ID</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($tests as $test)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ '#test-'.$test->id }}</td>
                                        <td>{{ \App\Models\Response::where('test_id', $test->id)->where('correct', true)->count() }}</td>

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
