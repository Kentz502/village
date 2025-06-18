<!-- Modal -->
<div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/resident/{{ $item->id }}" method="post">
        @csrf
        @method('DELETE')
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title fs-5" id="confirmationDeleteLabel">Delete Confirmation</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <span>Are you sure to delete this data?</span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Yes</button>
        </div>
        </div>
    </form>
  </div>
</div>
