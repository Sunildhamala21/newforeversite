<div class="py-4 kt-container kt-container--fluid">
    <div class="kt-subheader__main">
        <span class="kt-subheader__separator kt-hidden"></span>
        <?php $segments = request()->segments();
        ?>
        @if (count($segments) > 1)
            <div class="kt-subheader__breadcrumbs">
                <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
                <!-- <span class="kt-subheader__breadcrumbs-separator"></span> -->
                <?php $url = 'admin'; ?>
                @for ($i = 1; $i < count($segments); $i++)
                    <?php
                    if ($i + 2 == count($segments) && is_numeric($segments[$i + 1])) {
                        $url .= '/' . $segments[$i] . '/' . $segments[$i + 1];
                    } else {
                        $url .= '/' . $segments[$i];
                    }
                    ?>
                    <?php if (!is_numeric($segments[$i]) && ($segments[$i] != "dashboard")): ?>
                    <span class="kt-subheader__breadcrumbs-separator"> / </span>
                    <a href="{{ $url }}" class="kt-subheader__breadcrumbs-link">{{ breadCrumbTitle($segments[$i]) }}</a>
                    <?php endif ?>
                @endfor
            </div>
        @endif
    </div>
</div>
