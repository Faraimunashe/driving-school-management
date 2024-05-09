<x-app-layout>
    <div class="pagetitle">
        <h1>Vehicles</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Vehicles</li>
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
                        <h5 class="card-title">Vehicles</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtolfee">
                            Add New
                        </button>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Regnum</th>
                                    <th scope="col">Make</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Picture</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($vehicles as $vehicle)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $vehicle->regnum }}</td>
                                        <td>{{ $vehicle->make }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>{{ $vehicle->class }}</td>
                                        <td>
                                            <img src="{{asset('images/vehicles')}}/{{$vehicle->picture}}" alt="{{$vehicle->make}}" width="35">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editVehicle{{ $vehicle->id }}"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteVehicle{{ $vehicle->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                            <!-- Edit tolfee Modal -->
                                            <div class="modal fade" id="editVehicle{{ $vehicle->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Vehicles</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Regnum:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="regnum" value="{{$vehicle->regnum}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Make:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="make" value="{{$vehicle->make}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Model:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="model" value="{{$vehicle->model}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Class:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="class" value="{{$vehicle->class}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Picture:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="file" name="picture" class="form-control" accept="png,jpg,jpeg">
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

                                         <!-- Delete tolfee Modal -->
                                         <div class="modal fade" id="deleteVehicle{{ $vehicle->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Vehicle</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete {{ $vehicle->make }} from vehicle?</h6>
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
                <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Regnum:</label>
                            <div class="col-sm-10">
                                <input type="text" name="regnum" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Make:</label>
                            <div class="col-sm-10">
                                <input type="text" name="make" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Model:</label>
                            <div class="col-sm-10">
                                <input type="text" name="model" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Class:</label>
                            <div class="col-sm-10">
                                <select name="class" class="form-control" required>
                                    <option selected disabled>Select Class</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Picture:</label>
                            <div class="col-sm-10">
                                <input type="file" name="picture" class="form-control" accept="png,jpg,jpeg" required>
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
    <!-- End Large Modal-->
</x-app-layout>
