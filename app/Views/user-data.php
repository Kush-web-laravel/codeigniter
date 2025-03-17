<h3>Welcome to user data</h3>

<table border="1">
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php
            if(count($users) > 0){
                foreach($users as $index => $user){
                    ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php
                }
            }
        ?>
    </tbody>
</table>
    <?= 
        $pager->links();
    ?>