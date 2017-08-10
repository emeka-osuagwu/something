<?php $p = $pagination;
if ($p['previous_page'] || $p['next_page']) { ?>
<div class="row pgntn">
  <div class="small-3 medium-4 columns">
    <?php if ($p['previous_page']) { ?>
    <a href="<?= get_paginated_url($p['current_url'], $p['current_page'] - 1, $p['extra_info']); ?>">&lt;&lt; Prev</a>
    <?php } ?>
    &nbsp;
  </div>
  <div class="small-6 medium-4 columns pagination-centered">
    <ul class="pagination">
      <?php foreach (page_range($p['current_page'], $p['total_pages']) as $x) { ?>
        <li class="<?= $x == $p['current_page'] ? 'current' : ''; ?>"><a href="<?= get_paginated_url($p['current_url'], $x, $p['extra_info']); ?>"><?= $x ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="small-3 medium-4 columns text-right">
    &nbsp;
    <?php if ($p['next_page']) { ?>
    <a href="<?= get_paginated_url($p['current_url'], $p['current_page'] + 1, $p['extra_info']); ?>">Next &gt;&gt;</a>
    <?php } ?>
  </div>
</div>
<?php } ?>