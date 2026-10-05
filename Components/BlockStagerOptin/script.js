import { buildRefs } from '@/assets/scripts/helpers'

export default function (el) {
  const refs = buildRefs(el)

  refs.form.addEventListener('submit', onSubmit)

  async function onSubmit (event) {
    event.preventDefault()

    if (!refs.form.checkValidity()) {
      refs.form.reportValidity()
      return
    }

    const data = Object.fromEntries(new FormData(refs.form))
    setState('isLoading')

    try {
      const response = await fetch(refs.form.action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      if (!response.ok) throw new Error(response.statusText)
      refs.form.reset()
      setState('isSuccess', refs.successMessage.innerHTML)
    } catch (error) {
      setState('isError', refs.errorMessage.innerHTML)
    }
  }

  function setState (state, message = '') {
    refs.form.dataset.state = state
    refs.submit.disabled = state === 'isLoading'
    refs.message.hidden = !message
    refs.message.textContent = message
  }
}
