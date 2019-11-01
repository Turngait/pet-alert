export type MyEvent = EventTarget & {
  target: {
    value?: string,
    dataset?: {
      param?: string
    },
    classList?: {
      add?: Function,
      remove?: Function
    }
  }
};

export type MyNode = Node & {
  classList?: {
    remove?: Function,
    add?: Function
  },
  style?: {
    display?: string
  },
  setAttribute?: Function
};