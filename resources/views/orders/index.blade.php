<form action="{{ route('orders.filtre') }}" method="GET">
    <!-- Add your filters here -->
    <div class="form-group">
        <label for="burger_id">Burger</label>
        <select name="burger_id" id="burger_id" class="form-control">
            <!-- Populate with burger options -->
        </select>
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" name="date" id="date" class="form-control">
    </div>
    <div class="form-group">
        <label for="status">État</label>
        <select name="status" id="status" class="form-control">
            <option value="">Tous</option>
            <option value="paid">Payée</option>
            <option value="pending">En attente</option>
            <!-- Add more options as needed -->
        </select>
    </div>
    <div class="form-group">
        <label for="client_id">Client</label>
        <select name="client_id" id="client_id" class="form-control">
            <!-- Populate with client options -->
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
</form>
