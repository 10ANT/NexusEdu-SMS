<style>
/* Sidebar styles */
.sidebar {
  background-color: #222;
  border-right: 1px solid #222;
}

.sidebar .nav-link {
  color: #f5f5f5;
  padding: 12px 20px;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.3s, color 0.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
  background-color: #444;
  color: #fff;
}

.sidebar .nav-link i {
  margin-right: 10px;
  font-size: 16px;
}

.sidebar .nav-item-submenu .nav-link {
  padding-left: 40px;
}

.sidebar .nav-item-submenu .nav-group-sub .nav-link {
  padding-left: 50px;
}

.sidebar .sidebar-user {
  background-color: #333;
  padding: 20px;
  border-bottom: 1px solid #222;
}

.sidebar .sidebar-user .media-title {
  color: #f5f5f5;
}

.sidebar .sidebar-user .font-size-xs {
  color: #ccc;
}

.sidebar .sidebar-user .rounded-circle {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.sidebar .sidebar-mobile-toggler {
  background-color: #2b2b2b;
  padding: 10px 20px;
  color: #f5f5f5;
  border-bottom: 1px solid #222;
}

.sidebar .sidebar-mobile-toggler i {
  font-size: 18px;
}

/* Hover and active states */
.sidebar .nav-link:hover {
  background-color: #3b3b3b;
}

.sidebar .nav-link.active {
  background-color: #444;
  color: #fff;
}

/* Responsive styles */
@media (max-width: 767px) {
  .sidebar {
    position: fixed;
    top: 0;
    left: -240px;
    width: 240px;
    height: 100%;
    transition: left 0.3s;
    z-index: 1000;
  }

  .sidebar.sidebar-mobile-open {
    left: 0;
  }

  .sidebar-mobile-toggler {
    display: block;
    text-align: right;
    padding: 10px 20px;
    color: #f5f5f5;
  }
}
</style>

<div class="sidebar sidebar sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ route('my_account') }}"><img src="{{ Auth::user()->photo }}" width="38" height="38" class="rounded-circle" alt="photo"></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ ucwords(str_replace('_', ' ', Auth::user()->user_type)) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('my_account') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{--Academics--}}
                @if(Qs::userIsAcademic())

                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['drive-folders.index','']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="" class="nav-link"><i class="icon-graduation2"></i> <span> Google Classroom</span></a>


                    <ul class="nav nav-group-sub" data-submenu-title="Manage Academics">
                        <li class="nav-item"><a href="{{ route('classroom.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['classroom.index']) ? 'active' : '' }}">Classroom Management</a></li>
                    </ul>
                </li>

                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['tt.index', 'ttr.edit', 'ttr.show', 'ttr.manage']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-graduation2"></i> <span> Academics</span></a>


                        <ul class="nav nav-group-sub" data-submenu-title="Manage Academics">
                        {{--Timetables--}}
                            <li class="nav-item"><a href="{{ route('tt.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['tt.index']) ? 'active' : '' }}">Timetables</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['tt.index', 'ttr.edit', 'ttr.show', 'ttr.manage']) ? 'nav-item-expanded nav-item-open' : '' }} "">
                        <a href="#" class="nav-link"><i class="icon-book"></i> <span> Learning Tools</span></a>


                        <ul class="nav nav-group-sub" data-submenu-title="Manage Tools">
                            {{--Links--}}
                            <li class="nav-item"><p href="" class="nav-link" id="nexusChatBtn">AI Study Chatbot</p></li>
                            <li class="nav-item "><a href="https://pomofocus.io/" class="nav-link">Pomodoro Time Management</a></li>
                            <li class="nav-item"><a href="{{route("upload.papers")}}" class="nav-link {{ in_array(Route::currentRouteName(), ['upload.papers']) ? 'active' : '' }}">AI Test Paper Marker</a></li>

                            </ul>

                    </li>
                    @endif

                {{--Administrative--}}
                @if(Qs::userIsAdministrative())
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.invoice', 'payments.receipts', 'payments.edit', 'payments.manage', 'payments.show',]) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-office"></i> <span> Administrative</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Administrative">

                            {{--Payments--}}
                            @if(Qs::userIsTeamAccount())
                            <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.edit', 'payments.manage', 'payments.show', 'payments.invoice']) ? 'nav-item-expanded' : '' }}">

                                <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.create', 'payments.manage', 'payments.show', 'payments.invoice']) ? 'active' : '' }}">Payments</a>

                                <ul class="nav nav-group-sub">
                                    <li class="nav-item"><a href="{{ route('payments.create') }}" class="nav-link {{ Route::is('payments.create') ? 'active' : '' }}">Create Payment</a></li>
                                    <li class="nav-item"><a href="{{ route('payments.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.show']) ? 'active' : '' }}">Manage Payments</a></li>
                                    <li class="nav-item"><a href="{{ route('payments.manage') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.manage', 'payments.invoice', 'payments.receipts']) ? 'active' : '' }}">Student Payments</a></li>

                                </ul>

                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--Chat--}}
                      @if(Qs::userIsAdministrative())
                      <li class="nav-link">
                          <a href="http://127.0.0.1:8000/chatify" class="nav-link">
                              <i class="icon-bubbles4"></i>
                              <span>Chat</span>
                          </a>
                      </li>
                      @endif

                {{--Manage Students--}}
                @if(Qs::userIsTeamSAT())
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.create', 'students.list', 'students.edit', 'students.show', 'students.promotion', 'students.promotion_manage', 'students.graduated']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-users"></i> <span> Students</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Students">
                            {{--Admit Student--}}
                            @if(Qs::userIsTeamSA())
                                <li class="nav-item">
                                    <a href="{{ route('students.create') }}"
                                       class="nav-link {{ (Route::is('students.create')) ? 'active' : '' }}">Admit Student</a>
                                </li>
                            @endif

                            {{--Student Information--}}
                            <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.list', 'students.edit', 'students.show']) ? 'nav-item-expanded' : '' }}">
                                <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['students.list', 'students.edit', 'students.show']) ? 'active' : '' }}">Student Information</a>
                                <ul class="nav nav-group-sub">
                                    @foreach(App\Models\MyClass::orderBy('name')->get() as $c)
                                        <li class="nav-item"><a href="{{ route('students.list', $c->id) }}" class="nav-link ">{{ $c->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            @if(Qs::userIsTeamSA())

                            {{--Student Promotion--}}
                            <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['students.promotion', 'students.promotion_manage']) ? 'nav-item-expanded' : '' }}"><a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion', 'students.promotion_manage' ]) ? 'active' : '' }}">Student Promotion</a>
                            <ul class="nav nav-group-sub">
                                <li class="nav-item"><a href="{{ route('students.promotion') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion']) ? 'active' : '' }}">Promote Students</a></li>
                                <li class="nav-item"><a href="{{ route('students.promotion_manage') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion_manage']) ? 'active' : '' }}">Manage Promotions</a></li>
                            </ul>

                            </li>

                            {{--Student Graduated--}}
                            <li class="nav-item"><a href="{{ route('students.graduated') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['students.graduated' ]) ? 'active' : '' }}">Students Graduated</a></li>
                                @endif

                        </ul>
                    </li>
                @endif

                @if(Qs::userIsTeamSA())
                    {{--Manage Users--}}
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['users.index', 'users.show', 'users.edit']) ? 'active' : '' }}"><i class="icon-users4"></i> <span> Users</span></a>
                    </li>

                    {{--Manage Classes--}}
                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['classes.index','classes.edit']) ? 'active' : '' }}"><i class="icon-windows2"></i> <span> Classes</span></a>
                    </li>

                    {{--Manage Dorms--}}
                    <li class="nav-item">
                        <a href="{{ route('dorms.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['dorms.index','dorms.edit']) ? 'active' : '' }}"><i class="icon-home9"></i> <span> Dormitories</span></a>
                    </li>

                    {{--Manage Sections--}}
                    <li class="nav-item">
                        <a href="{{ route('sections.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['sections.index','sections.edit',]) ? 'active' : '' }}"><i class="icon-fence"></i> <span>Sections</span></a>
                    </li>

                    {{--Manage Subjects--}}
                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['subjects.index','subjects.edit',]) ? 'active' : '' }}"><i class="icon-pin"></i> <span>Subjects</span></a>
                    </li>
                @endif

                {{--Exam--}}
                @if(Qs::userIsTeamSAT())
                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['exams.index', 'exams.edit', 'grades.index', 'grades.edit', 'marks.index', 'marks.manage', 'marks.bulk', 'marks.tabulation', 'marks.show', 'marks.batch_fix',]) ? 'nav-item-expanded nav-item-open' : '' }} ">
                    <a href="#" class="nav-link"><i class="icon-books"></i> <span> Exams</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Manage Exams">
                        @if(Qs::userIsTeamSA())

                        {{--Exam list--}}
                            <li class="nav-item">
                                <a href="{{ route('exams.index') }}"
                                   class="nav-link {{ (Route::is('exams.index')) ? 'active' : '' }}">Exam List</a>
                            </li>

                            {{--Grades list--}}
                            <li class="nav-item">
                                    <a href="{{ route('grades.index') }}"
                                       class="nav-link {{ in_array(Route::currentRouteName(), ['grades.index', 'grades.edit']) ? 'active' : '' }}">Grades</a>
                            </li>

                            {{--Tabulation Sheet--}}
                            <li class="nav-item">
                                <a href="{{ route('marks.tabulation') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['marks.tabulation']) ? 'active' : '' }}">Tabulation Sheet</a>
                            </li>

                            {{--Marks Batch Fix--}}
                            <li class="nav-item">
                                <a href="{{ route('marks.batch_fix') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['marks.batch_fix']) ? 'active' : '' }}">Batch Fix</a>
                            </li>
                        @endif

                        @if(Qs::userIsTeamSAT())
                            {{--Marks Manage--}}
                            <li class="nav-item">
                                <a href="{{ route('marks.index') }}"
                                   class="nav-link {{ in_array(Route::currentRouteName(), ['marks.index']) ? 'active' : '' }}">Marks</a>
                            </li>

                            {{--Marksheet--}}
                            <li class="nav-item">
                                <a href="{{ route('marks.bulk') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['marks.bulk', 'marks.show']) ? 'active' : '' }}">Marksheet</a>
                            </li>

                            @endif

                    </ul>
                </li>
                @endif


                {{--End Exam--}}

                @include('pages.'.Qs::getUserType().'.menu')

                {{--Manage Account--}}
                <li class="nav-item">
                    <a href="{{ route('my_account') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['my_account']) ? 'active' : '' }}"><i class="icon-user"></i> <span>My Account</span></a>
                </li>

                </ul>
            </div>
        </div>
</div>



<button id="nexusChatBtn" class="nexus-chat-btn">
  <i class="chat-icon">💬</i>
</button>

<div id="nexusChatInterface" class="nexus-chat-interface">
  <div class="chat-header">
      <span class="chat-title">NexusChat</span>
      <button id="closeNexusChat" class="close-btn">×</button>
  </div>
  <div id="chatMessages" class="chat-messages"></div>
  <div class="chat-input">
      <input type="text" id="userInput" placeholder="Type your message...">
      <button id="sendMessage">Send</button>
  </div>
</div>


  <style>
  .nexus-chat-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #6b46c1 0%, #4299e1 100%);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(107, 70, 193, 0.2);
}

.nexus-chat-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
}

.chat-icon {
    width: 24px;
    height: 24px;
    color: white;
}

.nexus-chat-interface {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    box-shadow: 0 4px 20px rgba(107, 70, 193, 0.15);
    border-radius: 12px;
    overflow: hidden;
    display: none;
    z-index: 1001;
}

.nexus-chat-interface.open {
    display: block;
    animation: slideIn 0.3s ease;
}

.chat-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, #6b46c1 0%, #4299e1 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
    color: white;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.chat-messages {
    height: calc(100% - 120px);
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
}

.message {
    margin-bottom: 15px;
    max-width: 85%;
    padding: 12px 16px;
    border-radius: 15px;
    line-height: 1.4;
    font-size: 0.95rem;
}

.message.user {
    background: linear-gradient(135deg, #6b46c1 0%, #4299e1 100%);
    color: white;
    margin-left: auto;
}

.message.bot {
    background: white;
    color: #2d3748;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.chat-input {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 15px;
    background: white;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 10px;
}

.chat-input input {
    flex-grow: 1;
    padding: 10px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 25px;
    outline: none;
    transition: border-color 0.3s ease;
}

.chat-input input:focus {
    border-color: #6b46c1;
}

.chat-input button {
    padding: 8px 20px;
    background: linear-gradient(135deg, #6b46c1 0%, #4299e1 100%);
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chat-input button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(107, 70, 193, 0.2);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>





<script>
  $(document).ready(function() {
    const nexusChatBtn = $('#nexusChatBtn');
    const nexusChatInterface = $('#nexusChatInterface');
    const closeNexusChat = $('#closeNexusChat');
    const userInput = $('#userInput');
    const sendMessage = $('#sendMessage');
    const chatMessages = $('#chatMessages');

    const endpoint = "https://reave-m47vmaun-eastus2.cognitiveservices.azure.com/openai/deployments/gpt-4/chat/completions?api-version=2024-08-01-preview";
    const apiKey = "B0y6NCvCl07Ged7BjerGrj4DGl2oaeD93w74o4oRR5WL4xU4KWPzJQQJ99ALACHYHv6XJ3w3AAAAACOGUASP";

    nexusChatBtn.click(function() {
        nexusChatInterface.addClass('open');
    });

    closeNexusChat.click(function() {
        nexusChatInterface.removeClass('open');
    });

    sendMessage.click(sendUserMessage);
    userInput.keypress(function(e) {
        if (e.which == 13) {
            sendUserMessage();
        }
    });

    async function sendUserMessage() {
        const message = userInput.val().trim();
        if (message) {
            addMessageToChat('You', message, 'user');
            userInput.val('');
            
            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'api-key': apiKey
                    },
                    body: JSON.stringify({
                        messages: [
                            { role: "system", content: "You are NexusChat, a helpful AI assistant." },
                            { role: "user", content: message }
                        ],
                        max_tokens: 400,
                        temperature: 0.7
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                const botReply = data.choices[0].message.content;
                addMessageToChat('NexusChat', botReply, 'bot');
            } catch (error) {
                console.error('Error:', error);
                addMessageToChat('NexusChat', 'Sorry, I encountered an error. Please try again later.', 'bot');
            }
        }
    }

    function addMessageToChat(sender, message, type) {
        const messageElement = $('<div>').addClass('message').addClass(type);
        messageElement.append($('<span>').text(message));
        chatMessages.append(messageElement);
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
});
</script>



