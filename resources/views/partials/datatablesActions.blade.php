    <a class="btn btn-xs btn-primary" href="{{ route('grafico.' . '.show', $row->id) }}">
        Ver
    </a>

    <a class="btn btn-xs btn-info" href="{{ route('grafico.' . '.edit', $row->id) }}">
        Editar
    </a>

    <form action="{{ route('grafico.' . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ Estás seguro? }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="Eliminar">
    </form>