<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload & Manage your files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                           Choose the corresponding values
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                           For each column of the selected table, please choose the corresponding column from the uploaded file
                        </p>
                    </header>
                    <section>
                        <form action="{{ route('filePostConf',['file'=>$file['id']]) }}" method="post">
                            @csrf
                            <div class="space-y-12">
                                <div class="border-b border-gray-900/10 pb-12">
                                    @foreach($columns as $column=>$type)
                                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <h2 class="block text-lg font-bold leading-6 text-gray-900 dark:text-gray-400">{{ $column }} <span class="text-sm">{{ $type }}</span></h2>
                                                <div class="mt-2">
                                                    <select name="{{ $column }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 dark:text-gray-400 dark:bg-gray-800">
                                                        <option value="">Select a value</option>
                                                        <option value="ignore">Ignore This Column</option>
                                                        @foreach($fileColumns as $fileColumn)
                                                            @if(str_contains(strtolower($fileColumn), strtolower($column)))
                                                                <option value="{{$fileColumn}}" selected>{{$fileColumn}}</option>
                                                            @else
                                                                <option value="{{$fileColumn}}">{{$fileColumn}}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-10 space-y-10">
                                        <fieldset>
                                            <legend class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400">Erase the content table</legend>
                                            <div class="mt-6 space-y-6">
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex h-6 items-center">
                                                        <input id="comments" name="erase_table" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:bg-gray-800">
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="comments" class="font-medium text-gray-900 dark:text-gray-400">Yes</label>
                                                        <p class="text-gray-500 dark:text-gray-400">This will empty your table and delete all current eold entries</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400">Cancel</button>
                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
