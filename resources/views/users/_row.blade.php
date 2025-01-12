<tr class="">
    <!-- <td>{{$user->id}}</td> -->
    <th>
        {{ $user->name }} <!-- Columna para nombre rol y número de teléfono -->
        <span class="status st-{{$user->state}}"></span>
        <span class="note">Rol: {{trans("users.rol.{$user->role}")}}</span>
        <span class="note">Número de Teléfono:<br> {{ $user->profile->num_cel }}</span>
    </th>
    <td class="text-center">
    {{ $user->profile->ubicacion }} <!-- Columna para la dirección -->
    </td>
    <td class="text-center">
        {{ $user->email }} <!-- Columna para el correo electrónico -->
    </td>

    <td class="text-center"> <!-- Columna para ingreso al sistema y último inicio de sesión -->
        <span class="note">Ingreso al Sistema: {{ $user->created_at->format('d/m/Y') }}</span>
        <span class="note"> <strong>Último Inicio de Sesión: {{ $user->last_login != null ?  \Carbon\Carbon::create($user->last_login)->format('d-m-Y') : 'No disponible'  }}</strong></span>
    </td>
    <td class="text-center"> <!-- Botones de ver, editar y eliminar -->
        <div>
        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye-fill"></i> Ver Detalles</a>
        </div>
        <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button" @if(auth()->user()->id === $user->id) disabled @endif class="btn btn-outline-danger btn-sm" @click.prevent="deleteuser({{$user->id}})"><i class="bi bi-trash3-fill"></i> Eliminar</button>
        </div>
    </td>
</tr>
