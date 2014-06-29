     <div class='list-container'>
      <tr>
      <td><?php $listaccount->getfName() ?></td>
      <td><?php  $listaccount->getlName() ?></td>
      <td><a href='tel:"<?php $listaccount->getPhone() ?>'><?php $listaccount->getPhone() ?></a></td>
      <td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $account->getfName() ." tässä hei!' target=_'top'><?php  $listaccount->getEmail() ?></a></td>
      <td class='role-value'><?php  $listaccount->getRole() ?></td>
      <td></td>
      <td></td>
      </tr>
      </div>
