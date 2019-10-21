export type MyEvent = EventTarget & {
  target: {
    value?: string,
    dataset?: {
      param?: string
    },
    classList?: {
      add?: Function
    }
  }
};