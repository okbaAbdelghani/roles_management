<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> roles list</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('List Of Roles') }}
            </h2>
        </x-slot>
     
        <div class="py-12">
            <div class="max-w-7xl mb-2 mx-auto sm:px-6 lg:px-8 mb-4">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
                @endif
               
                <a type="button" href="{{ route('roles.create') }}" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add Role</a>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Role name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rowIndex = 0;
                            @endphp
                            @foreach ($roles as $role)
                                @php
                                    $rowIndex ++;
                                    $bgColor = $rowIndex % 2 === 0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800 ' ;
                                @endphp
                                <tr class="border-b {{ $bgColor }} dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$role->id}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$role->name}}
                                    </td>
                                    <td class="px-6 py-4">
                                        @can('role-list')
                                            <a type="button" href="{{ route('roles.show',['id' => $role->id]) }}" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 hover:cursor-pointer focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Show</a>
                                        @endcan

                                        @can('role-edit')
                                            <a type="button" href="{{ route('roles.edit',['id' => $role->id]) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 hover:cursor-pointer focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                                        @endcan

                                        @can('role-delete')
                                            <a type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 hover:cursor-pointer focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                    
                        </tbody>
                    </table>
         
                </div>
            </div>   
        </div>
    </x-app-layout>
</body>
</html>