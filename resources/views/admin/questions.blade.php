<x-app-layout>
    <div class="pagetitle">
        <h1>Questions</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Questions</li>
                </ol>
            </nav>
      </div>
    <section class="section">
        <div class="row">
            <x-alert/>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Questions</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtolfee">
                            Add New
                        </button>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($questions as $question)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $question->description }}</td>
                                        <td>
                                            <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$questions->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="addtolfee" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Question: <code>*</code></label>
                            <div class="">
                                <input type="text" name="description" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Correct Answer: <code>*</code></label>
                            <div class="">
                                <input type="text" name="correct_answer" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Disguise Question 1: <code>*</code></label>
                            <div class="">
                                <input type="text" name="answer_1" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Disguise Question 2: <code>*</code></label>
                            <div class="">
                                <input type="text" name="answer_2" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-form-label">Picture: <i>(Optional)</i></label>
                            <div class="">
                                <input type="file" name="picture" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
