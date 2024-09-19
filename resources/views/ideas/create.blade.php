<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="">
                        @csrf
                        @method('post')

                        <x-text-input id="tittle" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required placeholder="Ingresa título" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />

                        <textarea
                            name="description"
                            required
                            class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >{{ old('description', 'Mi Descripción......') }}  {{--old() mantiene la informacion vieja si hay un error al cargar  el nuevo--}}
                        </textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" /> {{--el nombre de la variable en get() debe ser el mismo que el que se designó en name="..."--}}

                        <div class="mt-4 space-x-8">
                            <x-primary-button>Guardar</x-primary-button>
                            <a href="#" class="dark:text-gray-100">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
