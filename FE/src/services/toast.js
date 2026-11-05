import { ref } from 'vue'

const toast = ref(null)
let timeoutId = null

export function dismissToast() {
  if (timeoutId) {
    clearTimeout(timeoutId)
    timeoutId = null
  }

  toast.value = null
}

export function showToast(message, type = 'info', duration = 3500) {
  const allowedTypes = ['success', 'danger', 'warning', 'info']

  dismissToast()
  toast.value = {
    message: String(message),
    type: allowedTypes.includes(type) ? type : 'info',
  }

  if (duration > 0) {
    timeoutId = setTimeout(dismissToast, duration)
  }
}

export function useToast() {
  return { toast, showToast, dismissToast }
}