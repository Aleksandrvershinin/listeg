let sending = false
const form = document.querySelector('.form__add-message')
const button = document.querySelector('.form__add-message_btn')
const responseElem = document.querySelector('#add-message__response')
form.addEventListener('submit', prepareSend)
const messageError = 'Что то пошло не так!'

function prepareSend(e) {
    e.preventDefault()
    if (sending) return
    responseElem.textContent = ""
    const data = new FormData(form)
    sendPost(data)
}
function toggleSending(param) {
    if (param !== true && param !== false) throw (new Error())
    sending = param
    button.disabled = param
}
function setResponse(message) {
    if (typeof message !== 'string') throw (new Error())
    if (message === 'success') {
        form.reset()
        responseElem.textContent = "Сообщение успешно отправлено"
    } else {
        responseElem.textContent = message
    }
}
async function sendPost(data) {
    toggleSending(true)
    try {
        const req = await fetch('/include/save_post.php', {
            method: 'POST',
            body: data,
        })
        if (req.ok) {
            const res = await req.json()
            setResponse(res)
        } else {
            setResponse(messageError)
        }
    } catch (error) {
        setResponse(messageError)
        throw (error)
    } finally {
        toggleSending(false)
    }
}