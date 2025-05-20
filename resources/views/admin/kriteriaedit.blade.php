@extends('layouts.main')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Kriteria</h5>

                    <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kriteria" class="form-label"><strong>Nama Kriteria</strong></label>
                            <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="desc_kriteria" class="form-label"><strong>Deskripsi Kriteria</strong></label>
                            <div id="desc_kriteria">
                                @php
                                $descArray = explode(',', $kriteria->desc_kriteria ?? '');
                                $nilaiArray = explode(',', $kriteria->nilai_kriteria ?? '');
                            @endphp


                                @foreach ($descArray as $index => $desc)
                                    <div class="input-group mb-2">
                                        <textarea class="form-control" name="desc_kriteria[]" placeholder="Deskripsi Kriteria" required rows="3">{{ old("desc_kriteria.$index", $desc) }}</textarea>
                                        <input type="text" class="form-control col-2" name="nilai_kriteria[]" value="{{ old("nilai_kriteria.$index", $nilaiArray[$index] ?? '') }}" placeholder="Nilai Kriteria" required>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeDescription(this)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-info" onclick="addDescription()">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>

                        <script>
                            document.querySelector("form").addEventListener("submit", function(e) {
                                const descs = document.querySelectorAll('textarea[name="desc_kriteria[]"]');
                                const nilais = document.querySelectorAll('input[name="nilai_kriteria[]"]');

                                let hasDesc = false;
                                let hasNilai = false;

                                descs.forEach((textarea) => {
                                    if (textarea.value.trim() !== "") {
                                        hasDesc = true;
                                    }
                                });

                                nilais.forEach((input) => {
                                    if (input.value.trim() !== "") {
                                        hasNilai = true;
                                    }
                                });

                                if (!hasDesc || !hasNilai) {
                                    e.preventDefault();
                                    alert("Minimal harus ada 1 Deskripsi Kriteria dan 1 Nilai Kriteria yang diisi.");
                                }
                            });
                            </script>


                        <a href="javascript:history.back()" class="btn btn-danger" title="Kembali">
                            <i class="ri-arrow-go-back-line"></i>
                        </a>
                        <button type="submit" class="btn btn-success">Update
                            <i class="ri-save-3-fill"></i>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Fungsi untuk menambah baris input deskripsi dan nilai
    function addDescription() {
        var div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <textarea class="form-control" name="desc_kriteria[]" placeholder="Deskripsi Kriteria" required rows="3"></textarea>
            <input type="text" class="form-control col-2" name="nilai_kriteria[]" placeholder="Nilai Kriteria" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeDescription(this)">
                <i class="fas fa-trash-alt"></i>
            </button>`;
        document.getElementById('desc_kriteria').appendChild(div);
    }

    // Fungsi untuk menghapus baris input deskripsi dan nilai
    function removeDescription(button) {
        button.closest('.input-group').remove();
    }
</script>

@endsection
