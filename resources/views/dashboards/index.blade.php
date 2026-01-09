<x-app-layout>
      <h1 class="text-xl font-bold mb-4">
        Dashboard
    </h1>
    
    @if (auth()->user()->role === 'admin')
        @include('dashboards.admin')
    @elseif(auth()->user()->role === 'employee')
        @include('dashboards.employee')
    @elseif(auth()->user()->role === 'client')
        @include('dashboards.client')
    @else
        <p>Role não encontrada: </p>
        <p>{{auth()->user()->role;}}</p>
       
    @endif

</x-app-layout>
