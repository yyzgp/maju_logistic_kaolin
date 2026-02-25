<input type="text" id="driver-filter" placeholder="Type to search for drivers" value=""
    class="form-control form-control-sm mb-2">
<div class="inbox-widget" id="inbox-widget" style="max-height: 397px;" data-simplebar>

    @foreach ($drivers as $key => $driver)
        <a href="javascript:void(0)" onclick="initGMap('Driver', {{ $driver['id'] }})" class="text-decoration-none">
            <div class="row">
                <div class="col-10">
                    <div class="inbox-item">

                        <div class="inbox-item-img"><img src="{{ $driver['avatar'] }}" class="rounded-circle"
                                alt="driver-image" width="55px"><span id="online-driver-{{ $driver['id'] }}"
                                class="text-success online-status-icon" style="display: none;">●</span><span
                                id="offline-driver-{{ $driver['id'] }}" class="text-muted offline-status-icon">●</span>
                        </div>
                        <p class="inbox-item-author">{{ $driver['firstname'] }}
                            {{ $driver['lastname'] }}</p>
                        <p class="hidden-item-author" style="display:none">
                            {{ str_replace(' ', '', $driver['firstname'] . ' ' . $driver['lastname']) }}</p>
                        <p class="inbox-item-text">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                style="width: {{ $driver['total_assigned_jobs'] }}%"
                                aria-valuenow="{{ $driver['total_assigned_jobs'] }}" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        </p>
                        <p class="inbox-item-date">
                            <a href="#" class="btn btn-sm btn-link text-info font-13">
                                {{ $driver['total_assigned_jobs'] }}/100 </a>
                        </p>


                    </div>
                </div>
                <div class="col-2" style="margin-top:35px;">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-form-select me-1"></i>Route
                            Optimization</a>
                        <a href="javascript:void(0)" class="dropdown-item"><i
                                class="mdi mdi-form-select me-1"></i>Recalculate ETA</a>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-form-select me-1"></i>Clear
                            ETA</a>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-form-select me-1"></i>Send
                            ETA
                            via Email</a>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
