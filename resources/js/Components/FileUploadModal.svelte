<script>
    import axios from "axios";
    import { page } from "@inertiajs/svelte";
    import ConvertApi from "convertapi-js";
    export let files, chatHistoryID, chatHistory, modal;

    const GenContext = async ()=>{
        let convertApi = ConvertApi.auth($page.props.convertSecret)
        let params = convertApi.createParams()
        if (files.length === undefined || files.length === 0)
        {return}
        let file = files[0]
        params.add('file', file)

        let filename = file.name
        let fileExtension = filename.split('.').pop();
        let convFileResult;
        //Make a switch statement to sort by filetype and send file to convert api to extract text
        switch (fileExtension){
            case 'doc':
                convFileResult = await convertApi.convert('doc', 'txt', params)
                break;
            case 'docx':
                convFileResult = await convertApi.convert('docx', 'txt', params)
                break;
            case 'pdf':
                convFileResult = await convertApi.convert('pdf', 'txt', params)
                break;
            default:

                return;
                break;
        }
        console.log(convFileResult)

        //Fetch text from converted file
        let text = await fetch(`${convFileResult.dto.Files[0].Url}`).then((res)=>{
            return res.text()
        })

        //Send extracted text
        await axios.post(`/GenContextFromFile/${chatHistoryID}`,
            {
                'text': text
            })
            .then((res)=>{
                console.log(res)
                chatHistory = [...chatHistory, {role: 'system', content: res.data.response}]
                if(!chatHistoryID)
                {
                    chatHistoryID = res.chatID;
                }
                modal = false;
            })
    }
</script>

<div class="fixed h-screen w-screen bg-gray-700 bg-opacity-75 flex justify-center align-middle items-center z-50" on:click|self={()=>{modal = false}}>
    <div class="absolute w-11/12 md:w-2/5 p-4 bg-white opacity-100 flex flex-col align-middle items-center">
        <span class="mb-4 font-sans text-black text-xl text-center">Upload a file for the AI to work with. We do not keep your uploaded files but we do save the generated context for you.</span>
        <input type="file" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" bind:files={files} max="1">
        <button class="mt-6 bg-blue-300 rounded font-bold text-xl p-3" on:click={GenContext}>Upload</button>
    </div>
</div>
