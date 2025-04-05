<table>
    <thead>
        <tr>
            <th id="id-header">ID</th>
            <th>Foto</th>
            <th>Nombre de Usuario</th>
            <th>Nombre Real</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Direcciones</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>".$user->getId()."</td>";
                echo "<td><img src='/Akihabara-Dreams/resources/images/usuarios/". $user->getProfilePic() . "'></td>";
                echo "<td>" . $user->getUserName() . "</td>";
                echo "<td>" . $user->getName() . "</td>";
                echo "<td>" . $user->getEmail() . "</td>";
                echo "<td>" . $user->getPhone() . "</td>";
                echo "<td><ul>";
                foreach ($user->getAddresses() as $item) {
                    echo "<li>$item</li>";
                }
                echo "</ul></td>";
                echo "<td>". $user->getRole() ."</td>";
                echo '<td>';
                    echo '<div class="actions">
                                <form action="/Akihabara-Dreams/usuarios/actualizar/'.$user->getId().'" method="POST">
                                    <input type="hidden" name="id" value="' . $user->getId() . '">
                                    <button type="submit" class="btn-update">Actualizar</button>
                                </form>
                                <form action="/Akihabara-Dreams/usuarios/eliminar/'.$user->getId().'" method="POST">
                                    <input type="hidden" name="id" value="' . $user->getId() . '">
                                    <button type="submit" class="btn-delete">Eliminar</button>
                                </form>
                        </div>';
                echo '</td>';
            echo "</tr>";
        }
        ?>

    </tbody>
</table>
<script src="/Akihabara-Dreams/resources/js/ordenarID.js"></script>
