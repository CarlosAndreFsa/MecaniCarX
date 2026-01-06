<x-app-layout>
      <h1 class="text-xl font-bold mb-4">
        Dashboard
    </h1>
    
    @if (auth()->user()->role === 'admin')
        @include('dashboard.admin')
    @elseif(auth()->user()->role === 'employee')
        @include('dashboard.employee')
    @elseif(auth()->user()->role === 'client')
        @include('dashboard.client')
    @else
        <p>Role não encontrada: </p>
        <p>{{auth()->user()->role;}}</p>
       
    @endif

</x-app-layout>
