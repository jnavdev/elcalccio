<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <!--   Acá instalamos el CDN que está disponible en la página de Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>El Calccio | Actualizar datos estudiante</title>
</head>

<body>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <div class="max-w-md mx-auto">
                    <div class="flex items-center space-x-5">
                        <div class="h-14 w-14 rounded-full flex flex-shrink-0 justify-center items-center">
                            <img src="{{ asset($student->profile_picture) }}" alt="">
                        </div>
                        <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                            <h2 class="leading-relaxed">{{ $student->full_name }}</h2>
                            <p class="text-sm text-gray-500 font-normal leading-relaxed">Por favor actualice sus datos.
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('parent_update_student_action', $encryptedId) }}" method="POST">
                        @method('PUT')
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-200 mt-6 border-t-4 border-red-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                                role="alert">
                                <div class="flex">
                                    <div>
                                        <p class="font-bold">Se encontraron los siguientes errores:</p>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="list-disc ml-4">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="divide-y divide-gray-200">
                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Nombre completo *</label>
                                    <input type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Ingrese nombre completo" name="full_name"
                                        value="{{ old('full_name', $student->full_name) }}">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="">
                                        <label class="leading-loose">RUT *</label>
                                        <input type="text"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese RUT" name="rut"
                                            value="{{ old('rut', $student->rut) }}">
                                    </div>
                                    <div class="">
                                        <label class="leading-loose">Fecha nacimiento *</label>
                                        <input type="date"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese fecha nacimiento" name="birth_date"
                                            value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="">
                                        <label class="leading-loose">Ciudad *</label>
                                        <select name="commune_id"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                                            @foreach ($communes as $commune)
                                                <option value="{{ $commune->id }}"
                                                    {{ $commune->id == $student->commune_id ? 'selected' : '' }}>
                                                    {{ $commune->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="">
                                        <label class="leading-loose">Dirección *</label>
                                        <input type="text"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese dirección" name="address"
                                            value="{{ old('address', $student->address) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="">
                                        <label class="leading-loose">Talla camiseta *</label>
                                        <input type="text"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese talla camiseta" name="shirt_size"
                                            value="{{ old('shirt_size', $student->shirt_size) }}">
                                    </div>
                                    <div class="">
                                        <label class="leading-loose">Talla pantalón *</label>
                                        <input type="number"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese talla pantalón" name="pants_size"
                                            value="{{ old('pants_size', $student->pants_size) }}">
                                    </div>
                                    <div class="">
                                        <label class="leading-loose">Num dorsal *</label>
                                        <input type="number"
                                            class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                            placeholder="Ingrese dorsal" name="shirt_number"
                                            value="{{ old('shirt_number', $student->shirt_number) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Discapacidad</label>
                                    <input type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Ingrese discapacidad" name="disability"
                                        value="{{ old('disability', $student->disability) }}">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Enfermedades</label>
                                    <input type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Ingrese enfermedades" name="diseases"
                                        value="{{ old('diseases', $student->diseases) }}">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Medicamentos</label>
                                    <input type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Ingrese medicamentos" name="medicines"
                                        value="{{ old('medicines', $student->medicines) }}">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Alergias</label>
                                    <input type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Ingrese alergias" name="allergies"
                                        value="{{ old('allergies', $student->allergies) }}">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Tipo sangre</label>
                                    <select name="blood_type"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                                        <option value="">Seleccione</option>
                                        <option value="A positivo"
                                            {{ $student->blood_type == 'A positivo' ? 'selected' : '' }}>A positivo
                                        </option>
                                        <option value="A negativo"
                                            {{ $student->blood_type == 'A negativo' ? 'selected' : '' }}>A negativo
                                        </option>
                                        <option value="B positivo"
                                            {{ $student->blood_type == 'B positivo' ? 'selected' : '' }}>B positivo
                                        </option>
                                        <option value="B negativo"
                                            {{ $student->blood_type == 'B negativo' ? 'selected' : '' }}>B negativo
                                        </option>
                                        <option value="AB positivo"
                                            {{ $student->blood_type == 'AB positivo' ? 'selected' : '' }}>AB positivo
                                        </option>
                                        <option value="AB negativo"
                                            {{ $student->blood_type == 'AB negativo' ? 'selected' : '' }}>AB negativo
                                        </option>
                                        <option value="O positivo"
                                            {{ $student->blood_type == 'O positivo' ? 'selected' : '' }}>O positivo
                                        </option>
                                        <option value="O negativo"
                                            {{ $student->blood_type == 'O negativo' ? 'selected' : '' }}>O negativo
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-4 flex items-center space-x-4">
                                <button
                                    class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"
                                    type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
