<x-app-layout>

    <div class="container mx-auto p-6">

        <h1 class="text-3xl font-bold mb-6">
            E-Aduan Keselamatan KSAS
        </h1>

        <div class="grid grid-cols-4 gap-4">

            <div class="bg-blue-500 text-white p-5 rounded">
                Total Aduan
                <h2>{{ $total }}</h2>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded">
                Pending
                <h2>{{ $pending }}</h2>
            </div>

            <div class="bg-purple-500 text-white p-5 rounded">
                Investigation
                <h2>{{ $investigation }}</h2>
            </div>

            <div class="bg-green-500 text-white p-5 rounded">
                Resolved
                <h2>{{ $resolved }}</h2>
            </div>

        </div>

    </div>

</x-app-layout>