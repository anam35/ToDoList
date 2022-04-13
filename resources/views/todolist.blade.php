<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ToDo List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div style="height: 60vh; display: flex; flex-direction:column;" class="p-6 bg-white border-b border-gray-200">
					<div id="ist" style="flex-grow: 4; margin:20px;">
						<table style="width: 100%">
							<caption>Popis zadataka</caption>
							<thead>
								<tr>
									<th>Zadatak</th>
									<th>Dodano</th>
									<th>Korisnik</th>
									<th>Završeno</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($list as $zadatak)
								<tr>
									<td>{{ $zadatak->zadatak }}</td>
									<td>{{ date("d.m.Y.", strtotime($zadatak->created_at)) }}</td>
									<td>{{ $zadatak->name }}</td>
									<td>
										@if($zadatak->stanje == 0)
											{{ date("d.m.Y.", strtotime($zadatak->updated_at)) }}
										@else
											<form style="display: inline-block" action="{{ route('todolist.update', $zadatak->id) }}" method="POST">
												@csrf
												@method('PUT')
												<input type="hidden" name="action" value="zavrsi">
												<button title="zavrsi">Završi zadatak</button>
											</form>
										@endif
									</td>
									<td>
										@if($zadatak->stanje == 1)
											<form style="display: inline-block" action="{{ route('todolist.edit', $zadatak->id) }}" method="POST">
												@csrf
												@method('GET')
												<button title="edit">Uredi</button>
											</form>
										
											<form style="display: inline-block" action="{{ route('todolist.destroy', $zadatak->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button title="delete">Delete</button>
											</form>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					@if (isset($edit))
						<form style="flex-grow: 1; margin:20px;" method="POST" action="{{route('todolist.update', $edit->id)}}">
							@csrf
							@method('PUT')
							<x-label for="zadatak" :value="__('Zadatak')" /><x-input id="zadatak" class="block mt-1 w-full" type="text" name="zadatak" value="{{ $edit->zadatak }}"/><br>
							<input type="hidden" name="action" value="uredi">
							<x-button class="ml-4" type="submit">Uredi zadatak</x-button>
						</form>
					@else
						<form style="flex-grow: 1; margin:20px;" method="POST" action="{{route('todolist.store')}}">
							@csrf
							<x-label for="zadatak" :value="__('Zadatak')" /><x-input id="zadatak" class="block mt-1 w-full" type="text" name="zadatak" :value="old('zadatak')"/><br>
							<x-button class="ml-4" type="submit">Novi zadatak</x-button>
						</form>
					@endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

