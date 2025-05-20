@extends('layouts.main')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Kriteria Baru</h5>
                    <form method="POST" action="{{ route('admin.kriteriastore') }}">
                        @csrf

                        <!-- Input untuk nama_kriteria -->
                        <div class="row mb-3">
                            <label for="nama_kriteria" class="col-sm-2 col-form-label"><strong>Nama Kriteria:</strong></label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_kriteria" class="form-control" id="nama_kriteria" placeholder="Masukan nama Kriteria" required>
                            </div>
                        </div>

                        <!-- Input dinamis untuk desc_kriteria dan nilai_kriteria -->
                        <div id="desc-container">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"><strong>Deskripsi Kriteria:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="desc_kriteria[]" class="form-control" placeholder="Deskripsi">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="nilai_kriteria[]" class="form-control" placeholder="Nilai">
                                </div>
                            </div>
                        </div>

                        <script>
                            document.querySelector("form").addEventListener("submit", function(e) {
                                const namaKriteria = document.getElementById("nama_kriteria").value.trim();
                                const descInputs = document.querySelectorAll('input[name="desc_kriteria[]"]');
                                const nilaiInputs = document.querySelectorAll('input[name="nilai_kriteria[]"]');

                                let isValid = true;
                                let errorMsg = "";

                                for (let i = 0; i < descInputs.length; i++) {
                                    const desc = descInputs[i].value.trim();
                                    const nilai = nilaiInputs[i].value.trim();

                                    // Jika nama kriteria diisi tapi deskripsi atau nilai kosong
                                    if (namaKriteria && (!desc || !nilai)) {
                                        isValid = false;
                                        errorMsg = "Lengkapi semua label";
                                        break;
                                    }

                                    // Jika deskripsi diisi tapi nilai atau nama kosong
                                    if (desc && (!nilai || !namaKriteria)) {
                                        isValid = false;
                                        errorMsg = "Lengkapi semua label";
                                        break;
                                    }

                                    // Jika nilai diisi tapi deskripsi atau nama kosong
                                    if (nilai && (!desc || !namaKriteria)) {
                                        isValid = false;
                                        errorMsg = "Lengkapi semua label";
                                        break;
                                    }
                                }

                                if (!isValid) {
                                    e.preventDefault();
                                    alert(errorMsg);
                                }
                            });
                            </script>


                        <button title="Tambah Deskripsi Kriteria" type="button" class="btn btn-sm btn-success" id="add-desc-field">
                            <i  class="fas fa-plus"></i>
                        </button>
                        <br><br>

                        <a href="javascript:history.back()" class="btn btn-danger" title="Kembali">
                            <i class="ri-arrow-go-back-line"></i>
                        </a>
                        <button title="Simpan" type="submit" class="btn btn-primary">Save
                            <i class="ri-save-3-fill"></i>
                        </button>
                    </form>

                    <script>
                    document.getElementById('add-desc-field').addEventListener('click', function () {
                        const container = document.getElementById('desc-container');
                        const row = `
                            <div class="row mb-3">
                                <div class="col-sm-8 offset-sm-2">
                                    <input type="text" name="desc_kriteria[]" class="form-control" placeholder="Deskripsi">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="nilai_kriteria[]" class="form-control" placeholder="Nilai">
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', row);
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
