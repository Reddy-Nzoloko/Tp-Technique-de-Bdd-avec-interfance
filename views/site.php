<?php
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
    
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-4 py-3 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Site de l'Hôpital Nord</h3>
            <span class="bg-blue-400 text-xs text-white px-2 py-1 rounded">ID: 12</span>
        </div>
        
        <div class="p-4">
            <h4 class="text-gray-500 uppercase text-xs font-semibold mb-3 tracking-wider">Services rattachés</h4>
            
            <ul class="space-y-2">
                <li class="flex justify-between items-center bg-gray-50 p-2 rounded hover:bg-gray-100 transition">
                    <div>
                        <span class="font-medium text-gray-800">Cardiologie</span>
                        <code class="ml-2 text-xs bg-gray-200 px-1 rounded text-blue-700 font-bold">CARD</code>
                    </div>
                    <button class="text-red-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </li>
            </ul>

            <button class="mt-4 w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-blue-500 hover:text-blue-500 transition flex justify-center items-center gap-2">
                <span class="text-xl">+</span> Ajouter un Service
            </button>
        </div>
    </div>

</div>
?>