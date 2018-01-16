<div class="modal fade" id="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content js-modal-wrap">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" class="card card-outline-danger">
                    <div class="card-header bg-danger text-white">Confirmez la suppression</div>
                    <div class="card-block">
                        <div class="form-group">
                            <label class="form-control-label" for="confirm">Ecrivez <i>test/confirm</i> avant de confirmer la suppression</label>
                            <input type="text" name="confirm" class="form-control" id="confirm">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
