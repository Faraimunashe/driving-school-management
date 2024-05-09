<x-app-layout>
    <div class="pagetitle">
        <h1>Question Answering</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Answering</li>
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
                            <form method="POST" action="{{route('responses.store')}}" class="col-6">
                                @csrf
                                <input type="hidden" name="test_id" value="{{$test_id}}" required>
                                <input type="hidden" name="question_id" value="{{$question->id}}" required>
                                @foreach ($answers as $answer)
                                    @php
                                        $count++;
                                    @endphp
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{$count}}</th>
                                            <td>{{$answer->description}}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="answer_id" id="gridRadios1" value="{{$answer->id}}">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
