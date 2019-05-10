<template>
    <div>
        <div class="chat-container">
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                            <div class="srch_bar">
                                <div class="stylish-input-group">
                                    <input type="text" class="search-bar" placeholder="Search">
                                    <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span></div>
                            </div>
                        </div>
                        <div class="inbox_chat">
                            <ul class="nav flex-column">
                                <li v-for="user in users"
                                    class="chat_people"
                                    :key="user.id"
                                    @click="openChat(user.id)"
                                    :class="{'font-weight-bold': chatUserID === user.id}">
                                    <a href="JavaScript:Void(0);">{{ user.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mesgs overflow-auto" v-show="chatOpen && !loadingMessages">
                        <div class="msg_history">
                            <div class="col-12" v-for="message in messages"
                                 :class="{'text-right': message.sender_id !== chatUserID}">
                                <small>{{ message.sender.name }} at {{ message.created_at }}</small>
                                <p>
                                    {{ message.message }}
                                </p>
                            </div>
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input type="text" class="write_msg" placeholder="Type a message" v-model="newMessage"
                                       v-on:keyup.enter="sendMessage"/>
                                <button class="msg_send_btn" type="button" @click="sendMessage"><i
                                        class="fa fa-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div v-show="loadingMessages">
                            <p>Loading messages... Please wait</p>
                        </div>
                        <div v-show="!chatOpen && !loadingMessages">
                            <p>No chat room is open. Please click on user to start a conversation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ChatApplication',
        data: () => {
            return {
                users: [],
                messages: [],
                chatOpen: false,
                chatUserID: null,
                loadingMessages: false,
                newMessage: ''
            }
        },
        created() {
            let app = this;
            app.loadUsers()
        },
        watch: {
            messages: function () {
                let element = this.$refs.messageBox;
                element.scrollTop = element.scrollHeight
            }
        },
        methods: {
            openChat(userID) {
                let app = this;
                if (app.chatUserID !== userID) {
                    app.chatOpen = true;
                    app.chatUserID = userID;

                    // Start pusher listener
                    Pusher.logToConsole = true;

                    var pusher = new Pusher('4f12eb3fd9b157bc3e62', {
                        cluster: 'ap2',
                        forceTLS: true
                    });

                    var channel = pusher.subscribe('newMessage-' + app.chatUserID + '-' + app.$root.userID); // newMessage-[chatting-with-who]-[my-id]

                    channel.bind('App\\Events\\MessageSent', function (data) {
                        if (app.chatUserID) {
                            app.messages.push(data.message);
                        }
                    });
                    this.loadMessages();
                }
            },
            loadUsers() {
                let app = this;
                axios.get('api/users')
                    .then((resp) => {
                        app.users = resp.data
                    })
            },
            loadMessages() {
                let app = this;
                app.loadingMessages = true;
                app.messages = [];
                axios.post('api/messages', {
                    sender_id: app.chatUserID
                }).then((resp) => {
                    app.messages = resp.data;
                    app.loadingMessages = false
                })
            },
            sendMessage() {
                let app = this;
                if (app.newMessage !== '') {
                    axios.post('api/messages/send', {
                        sender_id: app.$root.userID,
                        receiver_id: app.chatUserID,
                        message: app.newMessage
                    }).then((resp) => {
                        app.messages.push(resp.data);
                        app.newMessage = '';
                    })
                }
            }
        }
    }
</script>