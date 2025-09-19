<x-layouts.guest>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-center">Personaliza tu Proforma</h1>

        <!-- Tabla de productos agregados -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-900 rounded-xl shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left">Diseño</th>
                        <th class="px-4 py-3 text-left">Dimensiones</th>
                        <th class="px-4 py-3 text-center">Cantidad</th>
                        <th class="px-4 py-3 text-left">Acabado</th>
                        <th class="px-4 py-3 text-left">Opciones</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Simulación de productos agregados --}}
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">Ventana corrediza</td>
                        <td class="px-4 py-2">
                            <span class="block text-xs text-gray-500">Ancho:</span> <input type="number" min="0" value="120" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" /> cm<br>
                            <span class="block text-xs text-gray-500">Alto:</span> <input type="number" min="0" value="100" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" /> cm
                        </td>
                        <td class="px-4 py-2 text-center">
                            <input type="number" min="1" value="2" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" />
                        </td>
                        <td class="px-4 py-2">
                            <select class="w-32 px-2 py-1 rounded border border-gray-300 dark:border-gray-600">
                                <option>Aluminio natural</option>
                                <option>Blanco</option>
                                <option>Negro</option>
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <input type="checkbox" id="mosquitero1" class="mr-2"> <label for="mosquitero1">Mosquitero</label>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:scale-105 transition">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">Closet melamina</td>
                        <td class="px-4 py-2">
                            <span class="block text-xs text-gray-500">Ancho:</span> <input type="number" min="0" value="180" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" /> cm<br>
                            <span class="block text-xs text-gray-500">Alto:</span> <input type="number" min="0" value="220" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" /> cm<br>
                            <span class="block text-xs text-gray-500">Profundidad:</span> <input type="number" min="0" value="60" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" /> cm
                        </td>
                        <td class="px-4 py-2 text-center">
                            <input type="number" min="1" value="1" class="w-16 px-2 py-1 rounded border border-gray-300 dark:border-gray-600" />
                        </td>
                        <td class="px-4 py-2">
                            <select class="w-32 px-2 py-1 rounded border border-gray-300 dark:border-gray-600">
                                <option>Blanco mate</option>
                                <option>Roble</option>
                                <option>Negro</option>
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <input type="checkbox" id="puertas1" class="mr-2"> <label for="puertas1">Puertas corredizas</label>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:scale-105 transition">Eliminar</button>
                        </td>
                    </tr>
                    {{-- Puedes agregar más productos simulados aquí --}}
                </tbody>
            </table>
        </div>

        <!-- Botón para generar proforma y ver precios -->
        <div class="flex justify-center mt-10">
            <button type="button" class="bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white px-10 py-4 rounded-2xl font-bold text-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                Generar Proforma y Ver Precios
            </button>
        </div>

        <!-- Comentarios para integración backend -->
        {{-- 
            - Aquí solo se personalizan productos, no se muestran precios ni totales.
            - Al hacer clic en "Generar Proforma y Ver Precios" se debe procesar la orden y mostrar los precios en la siguiente vista o PDF.
            - Integra la lógica de costeo por orden de trabajo en el backend.
        --}}
    </div>
</x-layouts.guest>
