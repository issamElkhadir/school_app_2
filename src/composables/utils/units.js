export const bytesToHumanReadableSize = (bytes) => {
  const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
  if (bytes === 0) return "0 Byte";
  const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)).toString());
  return Math.round(bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
};

export const toUnit = (value, unit = "px") => {
  if (typeof value === "number") {
    return `${value}${unit}`;
  }

  return value;
};

export const convertToUnit = (str, unit = "px") => {
  if (str == null || str === "") {
    return undefined;
  } else if (isNaN(+str)) {
    return String(str);
  } else {
    return `${Number(str)}${unit}`;
  }
};
