<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('users/updatedata') ?>" class="formsimpan">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="useridlama" id="useridlama" value="<?= $userid ?>">
                    <input type="hidden" name="userktplama" id="userktplama" value="<?= $userktp ?>">
                    <input type="hidden" name="useremaillama" id="useremaillama" value="<?= $useremail ?>">

                    <div class="form-group">
                        <label for="">User ID</label>
                        <input type="text" name="userid" id="userid" value="<?= $userid ?>" class="form-control"
                            placeholder="Masukan User ID...">
                        <div class="invalid-feedback errorUserID"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User KTP</label>
                        <input type="text" name="userktp" id="userktp" value="<?= $userktp ?>" class="form-control"
                            placeholder="Masukan Nomor KTP...">
                        <div class="invalid-feedback errorUserKtp"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Nama</label>
                        <input type="text" name="usernama" id="usernama" value="<?= $usernama ?>" class="form-control"
                            placeholder="Masukan User Nama...">
                        <div class="invalid-feedback errorUserNama"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Email</label>
                        <input type="email" name="useremail" id="useremail" value="<?= $useremail ?>"
                            class="form-control" placeholder="Masukan User Email...">
                        <div class="invalid-feedback errorUserEmail"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Password</label>
                        <input type="password" name="userpassword" id="userpassword" value="<?= $userpassword ?>"
                            class="form-control" placeholder="Masukan User Password...">
                        <div class="invalid-feedback errorUserPassword"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Level</label>
                        <select name="userlevelid" id="userlevelid" class="form-control">
                            <option value="">Pilih Level</option>
                            <option value=""></option>
                            <?php foreach ($datalevel as $rowlevel) : ?>

                            <?php if ($rowlevel['levelid'] == $userlevelid) : ?>

                            <option value="<?= $rowlevel['levelid'] ?>" selected><?= $rowlevel['levelnama'] ?></option>

                            <?php else : ?>

                            <option value="<?= $rowlevel['levelid'] ?>"><?= $rowlevel['levelnama'] ?></option>

                            <?php endif; ?>

                            <?php endforeach; ?>





                        </select>
                        <div class="invalid-feedback errorUserLevelId"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan"
                        autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.formsimpan').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errUserID) {
                        $('#userid').addClass('is-invalid');
                        $('.errorUserID').html(err.errUserID);
                    } else {
                        $('#userid').removeClass('is-invalid');
                        $('#userid').addClass('is-valid');
                    }

                    if (err.errUserKtp) {
                        $('#userktp').addClass('is-invalid');
                        $('.errorUserKtp').html(err.errUserKtp);
                    } else {
                        $('#userktp').removeClass('is-invalid');
                        $('#userktp').addClass('is-valid');
                    }

                    if (err.errUserNama) {
                        $('#usernama').addClass('is-invalid');
                        $('.errorUserNama').html(err.errUserNama);
                    } else {
                        $('#usernama').removeClass('is-invalid');
                        $('#usernama').addClass('is-valid');
                    }

                    if (err.errUserEmail) {
                        $('#useremail').addClass('is-invalid');
                        $('.errorUserEmail').html(err.errUserEmail);
                    } else {
                        $('#useremail').removeClass('is-invalid');
                        $('#useremail').addClass('is-valid');
                    }

                    if (err.errUserPassword) {
                        $('#userpassword').addClass('is-invalid');
                        $('.errorUserPassword').html(err.errUserPassword);
                    } else {
                        $('#userpassword').removeClass('is-invalid');
                        $('#userpassword').addClass('is-valid');
                    }

                    if (err.errUserLevelId) {
                        $('#userlevelid').addClass('is-invalid');
                        $('.errorUserLevelId').html(err.errUserLevelId);
                    } else {
                        $('#userlevelid').removeClass('is-invalid');
                        $('#userlevelid').addClass('is-valid');
                    }

                }

                if (response.sukses) {
                    $('#modalEdit').modal('hide');
                    swal.fire(
                        'Berhasil',
                        response.sukses,
                        'success'
                    ).then((result) => {
                        window.location.reload();
                    })
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

        return false;
    });

    $('#batal').click(function(e) {
        e.preventDefault();
        window.location.reload();
    });

});
</script>