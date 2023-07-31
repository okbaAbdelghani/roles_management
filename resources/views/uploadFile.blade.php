<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Your File') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            @if ($message = Session::get('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @elseif ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-black-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Done! </strong>
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @endif
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                           Upload New File
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                           Upload xls files then click on Start
                        </p>
                    </header>
                    <section>
                        <form class="mt-2" action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-span-full">
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 dark:text-gray-400">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500 dark:text-gray-400 dark:bg-gray-800">
                                                <span>Upload a file</span>
                                                <input id="file-upload" name="file" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <div class="mt-2 mb-2 text-right">
                                    <button type="submit" name="submit" class="flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Upload Files
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                           All Uploaded files
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                           Here you can see all upload files that not processed yet
                        </p>
                    </header>
                    <section>
                            <table class="mt-2 table-auto caption-top w-full whitespace-no-wrapw-full whitespace-no-wrap">
                                <thead class="text-left">
                                    <th class="border px-4 py-2">Id</th>
                                    <th class="border px-4 py-2">Name</th>
                                    <th class="border px-4 py-2">Status</th>
                                    <th class="border px-4 py-2">Size</th>
                                    <th class="border px-4 py-2">By</th>
                                    <th class="border px-4 py-2">DB Table</th>
                                    <th class="border px-4 py-2"></th>
                                </thead>
                                @foreach($files as $file)
                                    <form action="{{ route('fileConf',['file'=>$file['id']]) }}" method="post">
                                        @csrf
                                        <tr class="p-2">
                                            <td class="border px-4 py-2">{{ $file['id'] }}</td>
                                            <td class="border px-4 py-2">{{ $file['name'] }}</td>
                                            <td class="border px-4 py-2">{{ $file['status'] }}</td>
                                            <td class="border px-4 py-2">{{ number_format($file['size']/1024,2) }} Kb</td>
                                            <td class="border px-4 py-2">{{ $file['user']['name'] }}</td>
                                            <td class="border px-4 py-2">
                                                @if($file['status'] === 'uploaded')
                                                    <select name="table_name"  class="w-full dark:text-gray-400 dark:bg-gray-800">
                                                        <option value="">Select a table</option>
                                                        @foreach($tables as $table)
                                                            <option value="{{$table}}"
                                                            @if ($file['table_name'] == $table)
                                                                selected="selected"
                                                            @endif
                                                            >{{$table}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ $file['table_name'] }}
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2 text-center">
                                                @if($file['status'] === 'uploaded')
                                                    <button  type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        Import File
                                                    </button>
                                                @endif
                                                @if($file['status'] === 'ready')
                                                   -
                                                @endif

                                                @if($file['status'] === 'processing')
                                                        @livewire('counter', ['fileId' => $file['id']])
                                                @endif

                                                @if($file['status'] === 'failed')
                                                        Try Again
                                                @endif

                                                @if($file['status'] === 'imported')
                                                        Done
                                                @endif
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </table>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
