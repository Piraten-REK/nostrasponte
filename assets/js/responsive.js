export const breakPoints = [768, 1366]

export const mediaSm = () => {
  return document.body.clientWidth < breakPoints[0]
}

export const mediaMd = () => {
  return document.body.clientWidth >= breakPoints[0]
}

export const mediaLg = () => {
  return document.body.clientWidth >= breakPoints[1]
}
