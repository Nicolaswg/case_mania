<tr class="">
    <!-- <td>{{$user->id}}</td> -->
    <th>
        {{ $user->name }}
        <span class="status st-{{$user->state}}"></span>
        <span class="note">Rol: {{trans("users.rol.{$user->role}")}}</span>
        <span class="note">Número de Teléfono : {{ $user->profile->num_cel }}</span>
    </th>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        {{ $user->email }}
    </td>

    <td class="text-center">
        <span class="note">Ingreso al Sistema: {{ $user->created_at->format('d/m/Y') }}</span>
        <span class="note"> <strong>Último Inicio de Sesión: {{ $user->last_login != null ?  \Carbon\Carbon::create($user->last_login)->format('d-m-Y') : 'No disponible'  }}</strong></span>
    </td>
    <td class="text-right">
        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button" @if(auth()->user()->id === $user->id) disabled @endif class="btn btn-outline-danger btn-sm" @click.prevent="deleteuser({{$user->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
