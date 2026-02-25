<div id="danger-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="danger-header-modalLabel">Assign Driver</h4>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('administrator.tasks.driver-assign') }}" method="POST" id="assignForm">
                    @csrf
                    <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                    @isset($task->service_id)
                    <input type="hidden" name="service" id="service" value="{{ $task->service_id }}">
                    @else
                    <p>Choose a service to assign task</p>
                    <select name="service" id="modal_service_id" class="form-select mb-3 select2" data-toggle="select2" data-placeholder="Choose Service" required>
                        <option value="">Choose Service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ old('service', $task->service_id) == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @endisset
                    <p>Choose a driver to assign task</p>
                    <div class="inbox-widget" style="max-height: 464px;" data-simplebar>
                        @foreach ($drivers as $key => $driver)
                            <div class="form-check">
                                <input type="radio" id="driver_{{ $driver['id'] }}" name="driver"
                                    value="{{ $driver['id'] }}" class="form-check-input">
                                <label class="form-check-label w-100" for="driver_{{ $driver['id'] }}">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{ $driver['avatar'] }}"
                                                class="rounded-circle avatar-image" alt=""><span
                                                id="online-driver-{{ $driver['id'] }}"
                                                class="text-success online-status-icon"
                                                style="display: none;">●</span><span
                                                id="offline-driver-{{ $driver['id'] }}"
                                                class="text-muted offline-status-icon">●</span></div>
                                        <ul class="driver-ul list-unstyled">
                                            <li class="driver-li">
                                                <p class="inbox-item-author">{{ $driver['firstname'] }}
                                                    {{ $driver['lastname'] }}</p>
                                            </li>
                                            <li class="driver-li">
                                                <p class="inbox-item-text"><span
                                                        class="badge bg-warning text-dark">Driver is
                                                        {{ $driver['distance'] }} km away</span></p>
                                            </li>
                                            <li class="driver-li">
                                                <p class="inbox-item-date">
                                                    <a href="#" class="btn btn-sm btn-link text-info font-13">
                                                        {{ $driver['total_assigned_jobs'] }}/100 </a>
                                                </p>
                                            </li>
                                        </ul>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                                style="width: {{ $driver['total_assigned_jobs'] }}%"
                                                aria-valuenow="{{ $driver['total_assigned_jobs'] }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>

                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="assignForm" class="btn btn-danger">Assign</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
