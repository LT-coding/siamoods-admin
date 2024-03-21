<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 mt-2">Խմբագրել տվյալները</h2>
    </header>

    <form method="post" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="name" label="Անուն" value="{{ old('name') ?? $user->name }}"/>
            </div>

            <div class="col-md-6">
                <x-adminlte-input name="lastname" label="Ազգանուն" value="{{ old('lastname') ?? $user->lastname }}"/>
            </div>
        </div>

        <x-adminlte-input name="email" label="Էլ․ հասցե" value="{{ old('email') ?? $user->email }}"/>

        <div class="text-right">
            <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Պահպանել" theme="success" icon="fas fa-lg fa-save"/>
        </div>
    </form>
</section>
