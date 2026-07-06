@extends('template.layout')

@section('content')

<div class="max-w-3xl mx-auto p-4">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit FAQ
        </h1>

        <p class="text-gray-500 mt-1">
            Perbarui pertanyaan dan jawaban FAQ.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <form action="{{ route('faq.update', $data->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                {{-- PERTANYAAN --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Pertanyaan
                    </label>

                    <input type="text"
                           name="pertanyaan"
                           value="{{ $data->pertanyaan }}"
                           class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    @error('pertanyaan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- JAWABAN --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Jawaban
                    </label>

                    <textarea name="jawaban"
                              rows="5"
                              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $data->jawaban }}</textarea>

                    @error('jawaban')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">

                <a href="{{ route('faq.index') }}"
                   class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100">
                    Kembali
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">
                    Update FAQ
                </button>

            </div>

        </form>

    </div>

</div>

@endsection