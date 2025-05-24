@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')

  <h1>Libros</h1>
  <form action="{{ route('register.store') }}" method="POST">
    @csrf
    <input name="titulo" type="text" placeholder="titulo">
    <input name="autor" type="text" placeholder="autor">
    <input name="dated" type="date" placeholder="date">
    <button type="submit">Register</button>
  </form>

  <table>
    <thead>
    <tr>
      <th scope="col" class="px-6 py-3 font-medium">titulo</th>
      <th scope="col" class="px-6 py-3 font-medium">autor</th>
      <th scope="col" class="px-6 py-3 font-medium">fecha</th>
    </tr>
    </thead>
    <tbody>
      @foreach($libros as $row)
        <td class="px-6 py-4 whitespace-nowrap">{{$row->titulo}}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $row->autor }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $row->fecha }}</td>
      @endforeach
    </tbody>
  </table>


@endsection
