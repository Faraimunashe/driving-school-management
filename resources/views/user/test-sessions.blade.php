<x-app-layout>
    <div class="pagetitle">
        <h1>Test Sessions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Sessions</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-12 mb-3">
                <a href="{{route('test-sessions.create')}}" class="btn btn-primary" style="float: right;">New Session</a>
            </div>
            <div class="col">
                <x-alert/>
            </div>
            @php
                $count = 0;
            @endphp
            @foreach ($sessions as $ses)
                @php
                    $count++;
                    $test_count = \App\Models\Test::where('test_session_id', $ses->id)->count();
                    //$res_count = \Appp\Models\Response::join('tests', 'tests.id', '=', 'responses.test_id')->where('test_session_id', $ses->id)->count();
                @endphp
                <div class="col-12">
                    <div class="card info-card customers-card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Options</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{route('test-sessions.show', $ses->id)}}">Open Session Tests</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Session - {{$count}} <span>created {{$ses->created_at->diffForHumans()}}</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$test_count}}</h6>
                                    @if ($test_count < 3)
                                        <span class="text-danger small pt-1 fw-bold">
                                            Incomplete
                                        </span>
                                    @else
                                        <span class="text-success small pt-1 fw-bold">
                                            Completed
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($sessions->isEmpty())
                <div class="alert alert-warning">You have no test sessions at the moment!</div>
            @endif
        </div>
    </section>
</x-app-layout>
