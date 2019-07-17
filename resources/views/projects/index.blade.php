@extends('layout')

@section('title','Projects')

@section('content')
    <div class="container">
        <h2>Projects</h2>
        <hr>

        <table class="table table-dark table-striped">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td class="text-center">
                            {{$project->id}}
                        </td>
                        <td class="text-center">
                            {{$project->title}}
                        </td>
                        <td class="text-center">
                            {{$project->description}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection