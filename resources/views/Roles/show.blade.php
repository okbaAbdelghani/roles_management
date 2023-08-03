<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>show role</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __( 'Role Details') }}
            </h2>
        </x-slot>
       
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <form method="POST" action="{{ route('roles.store')}}">
                    @csrf
                    <div class="mb-6">
                        <label for="role_name" class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Role name</label>
                        <input type="text" name="name" id="role_name" value="{{$role->name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="User" required>
                    </div> 
                    
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Permissions</h3>
                    <ul class="w-48 mb-4 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($allPermissions as $permission)
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input name="permissions[]" disabled   id="{{$permission->name}}" {{ in_array($permission->name, $rolePermissions->pluck('name')->toArray()) ? 'checked' : '' }} type="checkbox" value="{{$permission->name}}" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="vue-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$permission->name}}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @error('permissions')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
  
                </form>
            </div>   
        </div>
    </x-app-layout>
</body>
</html>