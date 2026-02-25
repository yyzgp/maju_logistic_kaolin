@extends('layouts.administrator')
@section('title', 'Calendar Management')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">
                        Calendar Management (Tasks)
                    </h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <div class="row">
            <div class="col-12">
                @include('administrator.calendar.filter')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/plugins/fullcalendar/dist/index.global.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar/packages/bootstrap5/index.global.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'dayGridDay,dayGridWeek,dayGridMonth',
                    center: 'title',
                    right: 'prev,today,next'
                },
                initialView: 'dayGridDay',
                initialDate: '{{ \Carbon\Carbon::now()->format('Y-m-d') }}',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @foreach ($tasks as $task)
                        {
                            title: "Task #{{ $task->id }}",
                            description: "{{ $task->type }}",
                            merchant: "{{ $task->merchant->name }}",
                            driver: "{{ $task->driver_id ? $task->driver->firstname . ' ' . $task->driver->lastname : 'Not Assigned' }}",
                            start: "{{ \Carbon\Carbon::parse($task->due_time)->format('Y-m-d') }}",
                            status: "{{ ucfirst($task->status) }}",
                            color: '#D82D36',
                            url: "{{ route('administrator.tasks.show', $task->id) }}"
                        },
                    @endforeach
                ],
                eventContent: function(arg) {

                    var event = arg.event;
                    var eventHtml = '<ul class="list-group list-unstyled">';
                    eventHtml +=
                        '<li class="list-group-item pt-2 pb-0 bg-danger text-white d-flex justify-content-between align-items-start" style="border:none !important">';
                    eventHtml += '<div class="ms-2 me-auto">';
                    eventHtml += '<div class="fw-bold">Task ID:</div>';
                    eventHtml += '</div>';
                    eventHtml += '<span>' + event.title + '</span>';
                    eventHtml += '</li>';
                    eventHtml +=
                        '<li class="list-group-item py-0 bg-danger text-white d-flex justify-content-between align-items-start" style="border:none !important">';
                    eventHtml += '<div class="ms-2 me-auto">';
                    eventHtml += '<div class="fw-bold">Task Type:</div>';
                    eventHtml += '</div>';
                    eventHtml += '<span>' + event.extendedProps.description + '</span>';
                    eventHtml += '</li>';
                    eventHtml +=
                        '<li class="list-group-item py-0 bg-danger text-white d-flex justify-content-between align-items-start" style="border:none !important">';
                    eventHtml += '<div class="ms-2 me-auto">';
                    eventHtml += '<div class="fw-bold">Workshop:</div>';
                    eventHtml += '</div>';
                    eventHtml += '<span>' + event.extendedProps.merchant + '</span>';
                    eventHtml += '</li>';
                    eventHtml +=
                        '<li class="list-group-item py-0 bg-danger text-white d-flex justify-content-between align-items-start" style="border:none !important">';
                    eventHtml += '<div class="ms-2 me-auto">';
                    eventHtml += '<div class="fw-bold">Driver:</div>';
                    eventHtml += '</div>';
                    eventHtml += '<span>' + event.extendedProps.driver + '</span>';
                    eventHtml += '</li>';
                    eventHtml +=
                        '<li class="list-group-item pt-0 pb-2 bg-danger text-white d-flex justify-content-between align-items-start" style="border:none !important">';
                    eventHtml += '<div class="ms-2 me-auto">';
                    eventHtml += '<div class="fw-bold">Status:</div>';
                    eventHtml += '</div>';
                    eventHtml += '<span>' + event.extendedProps.status + '</span>';
                    eventHtml += '</li>';
                    eventHtml += '</ul>';

                    return {
                        html: eventHtml
                    }
                },

            });

            calendar.render();
        });
    </script>
@endpush
