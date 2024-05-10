<script>
    import {page, useForm} from "@inertiajs/svelte";
    import axios from "axios";

    export let chatHistory = [], chatList=[];

    let chatHistoryID, input="";

    const generateChat = async ()=>{
        chatHistory = [...chatHistory, {role:"user", content: input}]
        //verstuur request
        axios.post("/ChatLLM",{
            chat: input,
            chatHistoryID: chatHistoryID||undefined,
            history: chatHistory,
        })
            .then((res)=>{
                if(res.chatID){
                    chatHistoryID=res.data.chatID
                }
                chatHistory = [...chatHistory, {role:'assistant', content: res.data.response}]
                console.log(res)
            })
    }

    function handleSubmit() {
        chatPrompt.history.push({ role: "user", content: chatPrompt.chat });
        chatPrompt.post('/ChatLLM');
    }

</script>

<style>
    .speech-bubble-ai {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #3b82f6;
        color: white;
        border-radius: 10px;
        position: relative;
    }

    .speech-bubble-ai:after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        border-left-color: #3b82f6;
        border-right: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-right: -11px;
    }



    .speech-bubble-user {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #3b82f6;
        color: white;
        border-radius: 10px;
        position: relative;
    }

    .speech-bubble-user:after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        border-right-color: #3b82f6;
        border-left: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-left: -11px;
    }

</style>



<body class="overflow-hidden h-screen">
    <div class="flex">
        <header class="header bg-gray-800 text-white absolute top-0 right-0 w-3/4 h-12 flex justify-between items-center ml-20">        <div class="logo relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-white before:rounded-full before:ml-2.5"></div>
            <div class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
        </header>

        <section class="border bg-blue-300 w-1/4 h-screen overflow-auto">

                <div class="text-center">
                    <p class="text-2xl">Chatgeschiedenis</p>
                </div>

                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    aaa
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    ccc
                </div>

                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    aaa
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    ccc
                </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
                aaa
            </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    ccc
                </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
                aaa
            </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    ccc
                </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
                aaa
            </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    ccc
                </div>
            <div class="bg-yellow-100 m-4 text-xl rounded-md">
                aaa
            </div>
                <div class="bg-yellow-100 m-4 text-xl rounded-md">
                    bbb
                </div>

            <div class="bg-yellow-100 m-4 text-xl rounded-md">
                  ccc
            </div>



        </section>
    </div>

    <section class="font-sans bg-white m-0 mt-[-700px] min-h-screen grid place-content-center gap-5 font-sans text-lg">
        <div class="speech-bubble-user">
    ddddddddd
        </div>

        <div class="speech-bubble-ai">
    dddddddddddddddddddddddddddddddd
        </div>
    </section>



    <section class="flex flex-col justify-between h-screen w-full">

        <div class="absolute bottom-0 right-0 container mx-auto flex justify-end h" style="height: 20%">
            <form on:submit|preventDefault={handleSubmit} class="bg-gray-100 flex items-center border border-gray-300 p-2 w-3/4">
                <input
                    class="bg-white border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2  ml-8"
                    type="text"
                    id="prompt"
                    bind:value={chatPrompt.chat}
                    style="width: 90%; height: 50%"
                    placeholder="Typ uw bericht hier..."
                />
                <button
                    type="submit"
                    class="bg-blue-500 text-white text-sm rounded-full p-2 ml-4"
                    style="width: 3.5rem; height: 3.5rem;"
                >
                    ➤
                </button>
            </form>
        </div>
    </section>


</body>