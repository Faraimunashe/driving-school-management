<x-app-layout>
    <div class="pagetitle">
        <h1>Question: {{$question->description}}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Question</li>
                </ol>
            </nav>
      </div>
    <section class="section">
        <div class="row">
            <x-alert/>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$question->description}}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                @if (isset($question->picture))
                                    <div class="carousel-inner">
                                        <img src="{{asset('images/answers')}}/{{$question->picture}}" height="200" alt="...">
                                    </div>
                                @else
                                    <div class="carousel-inner">
                                        <img src="{{asset('images/no-image.jfif')}}" height="200" alt="...">
                                    </div>
                                @endif
                            </div>
                            @php
                                $count = 0;
                            @endphp
                            <div class="col-6">
                                @foreach ($answers as $answer)
                                    @php
                                        $count++;
                                    @endphp
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{$count}}</th>
                                            <td>{{$answer->description}}</td>
                                        </tr>

                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
