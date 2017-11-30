<script>
    window.Admin = {};
    window.Admin.Lang = '{{ config('app.locale') }}'
    window.Admin.Title = '{{ config('admin.title') }}'
    window.Admin.UrlPrefix = '{{ config('admin.url_prefix') }}'

</script>

@auth
<script>
    window.Admin.LoggedUser = {
        'id': '{{Auth::id()}}',
        'name': '{{ Auth::user()->name }}',
        'role': {!! Auth::user()->roles->makeHidden([
            'description', 'created_at', 'updated_at', 'pivot', 'perms', 'deleted_at'
        ])->first(null, collect())->toJson() !!},
    }
</script>
@endauth

<script src="{{ mix('js/admin.js') }}"></script>