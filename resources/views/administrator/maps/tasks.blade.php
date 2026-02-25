<ul class="nav nav-pills bg-nav-pills nav-justified">
    <li class="nav-item">
        <a href="#assigned-tab" onclick="initGMap('Assigned', '')" data-bs-toggle="tab" aria-expanded="true"
            class="nav-link rounded-0 active" id="assigned">
            <span class="d-none d-md-block"><span class="pt-2">Assigned <h5><span
                            class="badge badge-outline-warning">{{ count($assigned_tasks) }}</span>
                    </h5></span></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#unassigned-tab" onclick="initGMap('Unassigned', '')" data-bs-toggle="tab" aria-expanded="false"
            class="nav-link rounded-0" id="unassigned">
            <span class="d-none d-md-block"><span class="pt-2">Unassigned <h5><span
                            class="badge badge-outline-warning">{{ count($unassigned_tasks) }}</span>
                    </h5></span></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#completed-tab" onclick="initGMap('Completed', '')" data-bs-toggle="tab" aria-expanded="false"
            class="nav-link rounded-0" id="completed">
            <span class="d-none d-md-block"><span class="pt-2">Completed <h5><span
                            class="badge badge-outline-warning">{{ count($completed_tasks) }}</span>
                    </h5></span></span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane show active" id="assigned-tab">
        <ul class="list-group">
            @foreach ($assigned_tasks as $akey => $task)
                <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-1">
                    <span>
                        <a href="javascript:void(0)" onclick="initGMap('Assigned', {{ $task->id }})"
                            class="text-decoration-none">
                            <i class="mdi mdi-google-maps me-1 text-danger"></i><small>{{ $task->address }}</small>
                            <br>
                            <i class="mdi mdi-account-outline me-1 text-danger"></i><small>{{ $task->name }}</small>
                            <br>
                            <i class="mdi mdi-phone me-1 text-danger"></i><small><a
                                    href="tel:{{ $task->dialcode . '-' . $task->phone }}">{{ $task->dialcode . '-' . $task->phone }}</a></small>
                            <br>
                            <i class="mdi mdi-trophy-outline me-1 text-danger"></i>
                            <span class="badge badge-outline-danger">{{ $task->type }}</span>
                            @isset($task->parent_task_id)
                                <span class="badge badge-outline-dark">Sub Task</span>
                                <span class="badge badge-outline-primary"><a
                                        href="{{ route('administrator.tasks.show', $task->parent_task_id) }}">Linked Parent
                                        Task</a></span>
                            @endisset
                        </a>
                    </span>

                    <span id="tooltip-container-assigned-{{ $akey }}">
                        <a href="javascript:void(0)"
                            data-bs-container="#tooltip-container-assigned-{{ $akey }}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ $task->driver->firstname . ' ' . $task->driver->lastname }}"><img
                                src="{{ isset($task->driver->avatar) ? asset('storage/uploads/drivers/' . $task->driver->slug . '/' . $task->driver->avatar) : 'https://placehold.co/30x30/D82D36/FFF?text=' . $task->driver->firstname[0] . '' . $task->driver->lastname[0] }}"
                                class="rounded-circle" width="42px">
                        </a>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="tab-pane" id="unassigned-tab">
        @foreach ($unassigned_tasks as $bkey => $task)
            <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-1">
                <span>
                    <a href="javascript:void(0)" onclick="initGMap('Unassigned', {{ $task->id }})"
                        class="text-decoration-none">
                        <i class="mdi mdi-google-maps me-1 text-danger"></i><small>{{ $task->address }}</small>
                        <br>
                        <i class="mdi mdi-account-outline me-1 text-danger"></i><small>{{ $task->name }}</small>
                        <br>
                        <i class="mdi mdi-phone me-1 text-danger"></i><small><a
                                href="tel:{{ $task->dialcode . '-' . $task->phone }}">{{ $task->dialcode . '-' . $task->phone }}</a></small>
                        <br>
                        <i class="mdi mdi-trophy-outline me-1 text-danger"></i>
                        <span class="badge badge-outline-danger">{{ $task->type }}</span>
                        @isset($task->parent_task_id)
                            <span class="badge badge-outline-dark">Sub Task</span>
                            <span class="badge badge-outline-primary"><a
                                    href="{{ route('administrator.tasks.show', $task->parent_task_id) }}">Linked Parent
                                    Task</a></span>
                        @endisset
                    </a>
                </span>

                <span id="tooltip-container-unassigned-{{ $bkey }}">
                    <a class="btn btn-sm btn-danger" href="javascript:void(0)"
                        onclick="assignDriver({{ $task->id }})">Assign</a>
                </span>
                {{-- data-bs-toggle="modal"
                                                                data-bs-target="#danger-header-modal" --}}
            </li>
        @endforeach
    </div>
    <div class="tab-pane" id="completed-tab">
        @foreach ($completed_tasks as $ckey => $task)
            <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-1">
                <span>
                    <a href="javascript:void(0)" onclick="initGMap('Completed', {{ $task->id }})"
                        class="text-decoration-none">
                        <i class="mdi mdi-google-maps me-1 text-danger"></i><small>{{ $task->address }}</small>
                        <br>
                        <i class="mdi mdi-account-outline me-1 text-danger"></i><small>{{ $task->name }}</small>
                        <br>
                        <i class="mdi mdi-phone me-1 text-danger"></i><small><a
                                href="tel:{{ $task->dialcode . '-' . $task->phone }}">{{ $task->dialcode . '-' . $task->phone }}</a></small>
                        <br>
                        <i class="mdi mdi-trophy-outline me-1 text-danger"></i>
                        <span class="badge badge-outline-danger">{{ $task->type }}</span>
                        @isset($task->parent_task_id)
                            <span class="badge badge-outline-dark">Sub Task</span>
                            <span class="badge badge-outline-primary"><a
                                    href="{{ route('administrator.tasks.show', $task->parent_task_id) }}">Linked Parent
                                    Task</a></span>
                        @endisset
                    </a>
                </span>

                <span id="tooltip-container-completed-{{ $ckey }}">
                    <a href="javascript:void(0)" data-bs-container="#tooltip-container-completed-{{ $ckey }}"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $task->driver?->firstname . ' ' . $task->driver?->lastname }}"><img
                            src="{{ isset($task->driver?->avatar) ? asset('storage/uploads/drivers/' . $task->driver?->slug . '/' . $task->driver?->avatar) : 'https://placehold.co/30x30/D82D36/FFF?text=' . $task->driver?->firstname[0] . '' . $task->driver?->lastname[0] }}"
                            class="rounded-circle" width="42px">
                    </a>
                </span>
            </li>
        @endforeach
    </div>
</div>
