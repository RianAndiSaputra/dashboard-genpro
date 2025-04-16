@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card 1 -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Total Users</h3>
        <p class="mt-2 text-3xl font-bold text-blue-600">1,234</p>
    </div>
    
    <!-- Card 2 -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Total Projects</h3>
        <p class="mt-2 text-3xl font-bold text-green-600">56</p>
    </div>
    
    <!-- Card 3 -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900">Pending Tasks</h3>
        <p class="mt-2 text-3xl font-bold text-yellow-600">12</p>
    </div>
</div>

<div class="mt-8 bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
    <!-- Activity content here -->
</div>
@endsection