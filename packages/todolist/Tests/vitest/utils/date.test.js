import {
    formatDateForApi,
    formatToLocaleDate,
    isToday,
    isBeforeToday
} from '../../../Resources/Private/Vue/utils/date.js'

import { describe, it, expect } from 'vitest'

describe('Date Utils', () => {
    const today = new Date()
    const notToday = new Date('2023-01-01')

    const todayISO = today.toISOString().split('T')[0]
    const notTodayISO = notToday.toISOString().split('T')[0]

    it('should format date for API', () => {
        const result = formatDateForApi('2025-07-20')
        expect(result).toBe('2025-07-20T00:00:00.000Z')
    })

    it('should format date to locale (de-DE)', () => {
        const result = formatToLocaleDate('2025-07-20')
        expect(result).toBe('20.7.2025')
    })

    it('should return true if date is today', () => {
        const result = isToday(todayISO, today)
        expect(result).toBe(true)
    })

    it('should return false if notToday is not today', () => {
        const result = isToday(notTodayISO, today)
        expect(result).toBe(false)
    })

    it('should return true if date is before today', () => {
        const result = isBeforeToday('2000-01-01', today)
        expect(result).toBe(true)
    })

    it('should return false if date is after today', () => {
        const futureDate = new Date()
        futureDate.setDate(today.getDate() + 5)
        const result = isBeforeToday(futureDate.toISOString().split('T')[0], today)
        expect(result).toBe(false)
    })

    it('should return true if notToday is before today', () => {
        const result = isBeforeToday(notTodayISO, today)
        expect(result).toBe(true)
    })
})