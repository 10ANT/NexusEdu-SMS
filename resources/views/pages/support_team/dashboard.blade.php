@extends('layouts.master')
@section('page_title', 'My Dashboard')
@section('content')

    @if(Qs::userIsTeamSA())
       <div class="row">
           <div class="col-sm-6 col-xl-3">
               <div class="card card-stats">
                   <div class="media">
                       <div class="media-body">
                           <h3 class="mb-0 text-white">{{ $users->where('user_type', 'student')->count() }}</h3>
                           <span class="text-uppercase font-size-xs font-weight-bold text-white-50">Total Students</span>
                       </div>

                       <div class="ml-3 align-self-center">
                           <i class="icon-users4 icon-3x text-white opacity-75"></i>
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-sm-6 col-xl-3">
               <div class="card card-stats card-accent">
                   <div class="media">
                       <div class="media-body">
                           <h3 class="mb-0 text-white">{{ $users->where('user_type', 'teacher')->count() }}</h3>
                           <span class="text-uppercase font-size-xs text-white-50">Total Teachers</span>
                       </div>

                       <div class="ml-3 align-self-center">
                           <i class="icon-users2 icon-3x text-white opacity-75"></i>
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-sm-6 col-xl-3">
               <div class="card card-stats">
                   <div class="media">
                       <div class="mr-3 align-self-center">
                           <i class="icon-pointer icon-3x text-white opacity-75"></i>
                       </div>

                       <div class="media-body text-right">
                           <h3 class="mb-0 text-white">{{ $users->where('user_type', 'admin')->count() }}</h3>
                           <span class="text-uppercase font-size-xs text-white-50">Total Administrators</span>
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-sm-6 col-xl-3">
               <div class="card card-stats card-accent">
                   <div class="media">
                       <div class="mr-3 align-self-center">
                           <i class="icon-user icon-3x text-white opacity-75"></i>
                       </div>

                       <div class="media-body text-right">
                           <h3 class="mb-0 text-white">{{ $users->where('user_type', 'parent')->count() }}</h3>
                           <span class="text-uppercase font-size-xs text-white-50">Total Parents</span>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    @endif

    {{--Events Calendar--}}
    <div class="card calendar-card mt-4">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">School Events Calendar</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="fullcalendar-basic"></div>
            @include('calendar')
        </div>
    </div>
@endsection

<style>
.card-stats {
    padding: 1.5rem;
    border: none;
    transition: transform 0.2s ease-in-out;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
}

 .card-stats:nth-child(1) {
    background: linear-gradient(135deg, #00b09b, #3d5ec9);
}

.card-stats:nth-child(2) {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
}

.card-stats:nth-child(3) {
    background: linear-gradient(135deg, #f7b733, #fc4a1a);
}

.card-stats:nth-child(4) {
    background: linear-gradient(135deg, #7f7fd5, #86a8e7);
}

.card-stats.card-accent {
    border-radius: 0 16px 16px 16px;
}

.card-stats:hover {
    transform: translateY(-5px) rotate(1deg);
}

.calendar-card {
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: none;
}

.calendar-card .card-header {
    background: white;
    border-radius: 20px 20px 0 0;
    border-bottom: 2px solid rgba(0,0,0,0.05);
}

.card-title {
    color: #333;
    font-weight: 600;
}

/* Add subtle patterns to cards */
.card-stats::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.1) 0%, transparent 20%);
}

/* Add a shine effect on hover */
.card-stats::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        to right,
        rgba(255,255,255,0) 0%,
        rgba(255,255,255,0.1) 50%,
        rgba(255,255,255,0) 100%
    );
    transform: rotate(45deg);
    transition: 0.5s;
    opacity: 0;
}

.card-stats:hover::after {
    opacity: 1;
}

@media (max-width: 768px) {
    .card-stats {
        margin-bottom: 1rem;
    }
}
</style>