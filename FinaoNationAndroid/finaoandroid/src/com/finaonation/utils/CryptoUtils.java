package com.finaonation.utils;

import java.security.InvalidKeyException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import javax.crypto.Mac;
import javax.crypto.spec.SecretKeySpec;

import android.util.Base64;

public final class CryptoUtils {
	
	public static String SHA1(String text, String key) throws NoSuchAlgorithmException {
		try {
			Mac mac = Mac.getInstance("HmacSHA1");
			SecretKeySpec secret = new SecretKeySpec(key.getBytes(), mac.getAlgorithm());
			
			mac.init(secret);
			byte[] digest = mac.doFinal(text.getBytes());
			
			String sig = convertToHex(digest); // split lines. easier to debug
			return sig;
		} catch (InvalidKeyException e) {
			e.printStackTrace();
		}
		
		return null;
	}

	private static String convertToHex(byte[] data) {
		StringBuffer buf = new StringBuffer();
		for (int i = 0; i < data.length; i++) {
			int halfbyte = (data[i] >>> 4) & 0x0F;
			int two_halfs = 0;
			do {
				if ((0 <= halfbyte) && (halfbyte <= 9))
					buf.append((char) ('0' + halfbyte));
				else
					buf.append((char) ('a' + (halfbyte - 10)));
				halfbyte = data[i] & 0x0F;
			} while (two_halfs++ < 1);
		}
		return buf.toString();
	}

	// MD5 routines
	public static final String md5(final String s) throws NoSuchAlgorithmException {
		// Create MD5 Hash
		MessageDigest digest = java.security.MessageDigest.getInstance("MD5");
		digest.update(s.getBytes());
		byte messageDigest[] = digest.digest();

		// Create Hex String
		StringBuffer hexString = new StringBuffer();
		for (int i = 0; i < messageDigest.length; i++) {
			String h = Integer.toHexString(0xFF & messageDigest[i]);
			while (h.length() < 2)
				h = "0" + h;
			hexString.append(h);
		}
		return hexString.toString();
	}

	public static final long timeSinceEpochLong() {
		long timesince1970 = System.currentTimeMillis();
		return timesince1970;
	}

	public static final String timeSinceEpochString() {
		long timesince1970 = System.currentTimeMillis();
		return Long.toString(timesince1970);
	}

	public static String toBase64fromString(String text) {
		byte bytes[] = text.getBytes();
		return Base64.encodeToString(bytes, Base64.DEFAULT);
	}

}
